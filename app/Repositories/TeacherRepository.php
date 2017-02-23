<?php namespace Scalex\Zero\Repositories;

use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;
use Ramsey\Uuid\Uuid;
use Request;
use Scalex\Zero\Criteria\OfSchool;
use Scalex\Zero\Models\Address;
use Scalex\Zero\Models\School;
use Scalex\Zero\Models\Teacher;
use Scalex\Zero\User;
use UnexpectedValueException;
use Znck\Attach\Builder;
use Znck\Repositories\Repository;

/**
 * @method Teacher find(string|int $id)
 * @method Teacher findBy(string $key, $value)
 * @method Teacher create(array $attr)
 * @method Teacher update(string|int|Teacher $id, array $attr, array $o = [])
 * @method Teacher delete(string|int|Teacher $id)
 * @method TeacherRepository validate(array $attr, Teacher|null $model)
 */
class TeacherRepository extends Repository
{
    /**
     * Class name of the Eloquent model.
     *
     * @var string
     */
    protected $model = Teacher::class;

    /**
     * Validation rules.
     *
     * @var array
     */
    protected $rules = [
        // Basic Information
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

        // Related to School
        'date_of_joining' => 'nullable|date',
        'job_title' => 'nullable|max:255',
        'department_id' => 'required|exists:departments,id',
        'specialization' => 'nullable|max:255',
        'biometric_id' => 'nullable|max:255',

        // Qualification.
        'education' => 'nullable',

        // Past Working Experience.
        'experience' => 'nullable',

        // Bank Account Details
        'bank' => 'nullable|max:255',
        'beneficiary_name' => 'nullable|max:255',
        'bank_account_number' => 'nullable|max:255',
        'ifsc_code' => 'nullable|max:255',
        'income_tax_id' => 'nullable|max:255',

        // Medical Details
        'is_disabled' => 'nullable|boolean',
        'disability' => 'required_if:is_disabled,1|max:255',
        'disease' => 'nullable|max:255',
        'allergy' => 'nullable|max:255',
        'visible_marks' => 'nullable|max:255',
        'food_habit' => 'nullable|array',
        'medical_remarks' => 'nullable|max:65536',

        // Maintenance Information
        'archived' => 'nullable|boolean',
        'remarks' => 'nullable|max:65536',
    ];

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
                    Rule::unique('teachers')->where('school_id', $id),
                ],
                'department_id' => [
                    'required',
                    Rule::exists('departments', 'id')->where('school_id', $id),
                ],
                'photo_id' => [
                    'nullable',
                    Rule::exists('attachments', 'id')->where('school_id', $id),
                ],
            ];
    }

    /**
     * @param array $rules
     * @param array $attributes
     * @param Teacher $teacher
     *
     * @return array
     */
    public function getUpdateRules(array $rules, array $attributes, $teacher)
    {
        $rules = $this->getCreateRulesForSchool($teacher->school);

        $rules['uid'] = [
            'required',
            Rule::unique('teachers')
                ->where('school_id', $teacher->school->getKey())
                ->ignore($teacher->getKey()),
        ];

        return array_only($rules, array_keys($attributes));
    }


    public function creating(Teacher $teacher, array $attributes)
    {
        throw new UnexpectedValueException('Use `createForSchool` method instead of `create`.');
    }

    public function updating(Teacher $teacher, array $attributes)
    {
        $teacher->department()->associate($attributes['department_id'] ?? $teacher->department_id);

        return $teacher->update($attributes);
    }

    public function createForSchool(School $school, array $attributes)
    {
        $this->validateWith($attributes, $this->getCreateRulesForSchool($school));

        $teacher = new Teacher($attributes);

        $teacher->department()->associate($attributes['department_id'] ?? null);
        $teacher->photo()->associate($attributes['photo_id'] ?? null);
        $teacher->school()->associate($school);

        $this->onCreate($teacher->save());

        return $teacher;
    }

    public function updateAddress(Teacher $teacher, array $attributes)
    {
        $repository = repository(Address::class);

        if ($teacher->address) {
            $repository->update($teacher->address, $attributes);
        } else {
            $address = $repository->create($attributes);

            $teacher->address()->associate($address);

            $this->onUpdate($teacher->save());
        }

        return $teacher;
    }

    public function uploadPhoto(Teacher $teacher, UploadedFile $photo, User $user)
    {
        if (!$photo->isValid()) {
            throw new UploadException('Invalid photo.');
        }

        // Set path & slug.
        $attributes['path'] = $this->getPhotoUploadPath($teacher);
        $attributes['slug'] = $attributes['slug'] ?? Uuid::uuid4();

        // Prepare uploader.
        $uploader = Builder::makeFromFile($photo)->resize(360, 'preview', 360);
        ;

        // Upload & get attachment.
        $attachment = $uploader->upload($attributes);

        $attachment->owner()->associate($user);
        $attachment->related()->associate($teacher);

        $this->onCreate($attachment->save());

        // Associate photo to the teacher.
        $teacher->photo()->associate($attachment);

        $this->onUpdate($teacher->save());

        return $attachment;
    }

    protected function getPhotoUploadPath(Teacher $teacher)
    {
        return "schools/{$teacher->school_id}/teachers/photo/{$teacher->id}";
    }
}
