<?php namespace Scalex\Zero\Repositories;

use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;
use Ramsey\Uuid\Uuid;
use Request;
use Scalex\Zero\Criteria\OfSchool;
use Scalex\Zero\Models\Address;
use Scalex\Zero\Models\Guardian;
use Scalex\Zero\Models\School;
use Scalex\Zero\Models\Student;
use Scalex\Zero\User;
use UnexpectedValueException;
use Znck\Attach\Builder;
use Znck\Repositories\Repository;

/**
 * @method Student find(string | int $id)
 * @method Student findBy(string $key, $value)
 * @method Student create(array $attr)
 * @method Student update(string | int | Student $id, array $attr, array $o = [])
 * @method Student delete(string | int | Student $id)
 * @method StudentRepository validate(array $attr, Student | null $model)
 */
class StudentRepository extends Repository
{
    /**
     * Class name of the Eloquent model.
     *
     * @var string
     */
    protected $model = Student::class;

    /**
     * Validation rules.
     *
     * @var array
     */
    protected $rules = [
        // Basic Information.
        'first_name' => 'required|max:255',
        'middle_name' => 'nullable|max:255',
        'last_name' => 'required|max:255',
        'date_of_birth' => 'required|date',
        'gender' => 'nullable|in:female,male,other',
        'blood_group' => 'nullable|in:A+,A-,AB+,AB-,B+,B-,O+,O-',
        'category' => 'nullable|in:gen,obc,sc,st,ot',
        'religion' => 'nullable|max:255',
        'language' => 'nullable|max:255',
        'passport' => 'nullable|max:255',
        'govt_id' => 'nullable|max:255',

        // Related to School.
        'date_of_admission' => 'nullable|date',
        'boarding_type' => 'nullable|in:hosteler,day_scholar',
        'biometric_id' => 'nullable|max:255',

        // Medical Information.
        'is_disabled' => 'nullable|boolean',
        'disability' => 'required_if:is_disabled,1|max:255',
        'disease' => 'nullable|max:255',
        'allergy' => 'nullable|max:255',
        'visible_marks' => 'nullable|max:255',
        'food_habit' => 'nullable|array',
        'medical_remarks' => 'nullable|max:65536',

        // Maintenance Information.
        'archived' => 'nullable|boolean',
        'remarks' => 'nullable|max:65536',
    ];

    /**
     * Push default criteria to limit search to a school.
     */
    public function boot()
    {
        if ($user = Request::user()) {
            $this->pushCriteria(new OfSchool($user->school));
        }
    }

    public function getCreateRulesForSchool(School $school)
    {
        $id = $school->getKey();

        return $this->rules + [
                'uid' => [
                    'required',
                    Rule::unique('students')->where('school_id', $id),
                ],
                'department_id' => [
                    'required',
                    Rule::exists('departments', 'id')->where('school_id', $id),
                ],
                'discipline_id' => [
                    'required',
                    Rule::exists('disciplines', 'id')->where('school_id', $id),
                ],
                'photo_id' => [
                    'nullable',
                    Rule::exists('attachments', 'id')->where('school_id', $id),
                ],
            ];
    }

    /**
     * Prepare update rules.
     *
     * @param array $rules
     * @param array $attributes
     * @param \Scalex\Zero\Models\Student $student
     *
     * @return array
     */
    public function getUpdateRules(array $rules, array $attributes, $student)
    {
        $rules = $this->getCreateRulesForSchool($student->school);

        $rules['uid'] = [
            'required',
            Rule::unique('students')
                ->where('school_id', $student->school->getKey())
                ->ignore($student->getKey()),
        ];

        return array_only($rules, array_keys($attributes));
    }

    public function creating()
    {
        throw new UnexpectedValueException('Use `createForSchool` method instead of `create`.');
    }

    public function updating(Student $student, array $attributes)
    {
        $student->department()->associate($attributes['department_id'] ?? $student->department_id);
        $student->discipline()->associate($attributes['discipline_id'] ?? $student->discipline_id);

        return $student->update($attributes);
    }

    public function createForSchool(School $school, array $attributes)
    {
        $this->validateWith($attributes, $this->getCreateRulesForSchool($school));

        $student = new Student($attributes);

        $student->department()->associate($attributes['department_id'] ?? null);
        $student->discipline()->associate($attributes['discipline_id'] ?? null);
        $student->photo()->associate($attributes['photo_id'] ?? null);
        $student->school()->associate($school);

        $this->onCreate($student->save());

        return $student;
    }

    public function updateAddress(Student $student, array $attributes)
    {
        $repository = repository(Address::class);

        if ($student->address) {
            $repository->update($student->address, $attributes);
        } else {
            $address = $repository->create($attributes);

            $student->address()->associate($address);

            $this->onUpdate($student->save());
        }

        return $student;
    }

    public function updateFather(Student $student, array $attributes)
    {
        $repository = repository(Guardian::class);

        if ($student->father) {
            $repository->update($student->father, $attributes);
        } else {
            $father = $repository->createForSchool($student->school, $attributes);

            $student->father()->associate($father);

            $this->onUpdate($student->save());
        }

        return $student;
    }

    public function updateMother(Student $student, array $attributes)
    {
        $repository = repository(Guardian::class);

        if ($student->mother) {
            $repository->update($student->mother, $attributes);
        } else {
            $mother = $repository->createForSchool($student->school, $attributes);

            $student->mother()->associate($mother);

            $this->onUpdate($student->save());
        }

        return $student;
    }

    public function uploadPhoto(Student $student, UploadedFile $photo, User $user)
    {
        if (!$photo->isValid()) {
            throw new UploadException('Invalid photo.');
        }

        // Set path & slug.
        $attributes['path'] = $this->getPhotoUploadPath($student);
        $attributes['slug'] = $attributes['slug'] ?? Uuid::uuid4();

        // Prepare uploader.
        $uploader = Builder::makeFromFile($photo)->resize(360, 'preview', 360);

        // Upload & get attachment.
        $attachment = $uploader->upload($attributes);

        $attachment->owner()->associate($user);
        $attachment->related()->associate($student);

        $this->onCreate($attachment->save());

        // Associate photo to the student.
        $student->photo()->associate($attachment);

        $this->onUpdate($student->save());

        return $attachment;
    }

    protected function getPhotoUploadPath(Student $student)
    {
        return "schools/{$student->school_id}/students/photo/{$student->id}";
    }
}
