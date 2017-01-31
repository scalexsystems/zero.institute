<?php namespace Scalex\Zero\Repositories;

use Illuminate\Support\Collection;
use Scalex\Zero\Criteria\OfSchool;
use Scalex\Zero\Models\Attachment;
use Scalex\Zero\Models\Geo\Address;
use Scalex\Zero\Models\Guardian;
use Scalex\Zero\Models\School;
use Scalex\Zero\Models\Student;
use Scalex\Zero\User;
use Znck\Repositories\Repository;

/**
 * @method Student find(string|int $id)
 * @method Student findBy(string $key, $value)
 * @method Student create(array $attr)
 * @method Student update(string|int|Student $id, array $attr, array $o = [])
 * @method Student delete(string|int|Student $id)
 * @method StudentRepository validate(array $attr, Student|null $model)
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
        'photo_id' => 'nullable|exists:attachments,id',
        'first_name' => 'required|max:255',
        'middle_name' => 'nullable|max:255',
        'last_name' => 'required|max:255',
        'date_of_birth' => 'required|date',
        'gender' => 'required|in:female,male,other',
        'blood_group' => 'nullable|in:A+,A-,AB+,AB-,B+,B-,O+,O-',
        'category' => 'nullable|in:gen,obc,sc,st,ot',
        'religion' => 'nullable|max:255',
        'language' => 'nullable|max:255',
        'passport' => 'nullable|max:255',
        'govt_id' => 'nullable|max:255',

        // Related to School.
        'uid' => 'required|unique:students,uid,NULL,id,school_id,',
        'date_of_admission' => 'nullable|date',
        'boarding_type' => 'nullable|in:hosteler,day_scholar',
        'department_id' => 'required|exists:departments,id',
        'discipline_id' => 'required|exists:disciplines,id',
        'biometric_id' => 'nullable|max:255',

        // Contact Information.
        'address_id' => 'required|exists:addresses,id',

        // Parent's Information.
        'father_id' => 'required|exists:guardians,id',
        'mother_id' => 'required|exists:guardians,id',

        // Medical Information.
        'is_disabled' => 'nullable|boolean',
        'disability' => 'required_if:is_disabled,1|max:255',
        'disease' => 'nullable|max:255',
        'allergy' => 'nullable|max:255',
        'visible_marks' => 'nullable|max:255',
        'food_habit' => 'nullable|in:veg,non_veg',
        'medical_remarks' => 'nullable|max:65536',

        // Maintenance Information.
        'archived' => 'nullable|boolean',
        'remarks' => 'nullable|max:65536',
        'school_id' => 'required|exists:schools,id',
    ];

    public function boot()
    {
        if (current_user()) {
            $this->pushCriteria(new OfSchool(current_user()->school));
        }
    }

    /**
     * @param array $rules
     * @param array $attributes
     * @param Student $student
     *
     * @return array
     */
    public function getUpdateRules(array $rules, array $attributes, $student)
    {
        $rules += array_dot(
            [
                'address' => repository(Address::class)->getRules($attributes, $student->address),
                'mother' => repository(Guardian::class)->getRules($attributes, $student->mother),
                'father' => repository(Guardian::class)->getRules($attributes, $student->father),
            ]);

        $rules['uid'] = 'required|unique:teachers,uid,'.$student->uid.',id,school_id,'.current_user()->school_id;

        return array_only($rules, array_keys($attributes));
    }

    public function getCreateRules(array $attributes)
    {
        $guardianRules = repository(Guardian::class)->getRules($attributes);

        $this->rules['uid'] = 'required|unique:teachers,uid,NULL,id,school_id,'.current_user()->school_id;

        return $this->rules + array_dot(
            [
                'address' => repository(Address::class)->getRules($attributes),
                'mother' => $guardianRules,
                'father' => $guardianRules,
            ]);
    }

    public function creating(Student $student, array $attributes)
    {
        $student->fill($attributes);

        $student->address()->associate(repository(Address::class)->create(array_get($attributes, 'address', [])));
        $student->department()->associate(find($attributes, 'department_id'));
        $student->discipline()->associate(find($attributes, 'discipline_id'));
        $student->father()->associate(find($attributes, 'father_id', Guardian::class));
        $student->mother()->associate(find($attributes, 'mother_id', Guardian::class));
        $student->school()->associate(find($attributes, 'school_id'));
        attach_attachment($student, 'profilePhoto', find($attributes, 'photo_id', Attachment::class));

        $student->bio = $this->getBio($student);

        $status = $student->save();

        if ($status and $student->address) {
            $student->address->addressee()->associate($student)->save();
        }

        return $status;
    }

    public function updating(Student $student, array $attributes)
    {
        $student->fill($attributes);

        if (array_has($attributes, 'address') && !empty($attributes['address'])) {
            if (isset($student->address)) {
                repository(Address::class)
                    ->update($student->address, $attributes['address']);

            } else {
                $student->address()->associate(repository(Address::class)->create(array_get($attributes, 'address', [])));
            }
        }
        if (array_has($attributes, 'department_id')) {
            $student->department()->associate(find($attributes, 'department_id'));


        }
        if (array_has($attributes, 'discipline_id')) {
            $student->discipline()->associate(find($attributes, 'discipline_id'));
        }
        if (array_has($attributes, 'photo_id')) {
            attach_attachment($student, 'profilePhoto', find($attributes, 'photo_id', Attachment::class));
        }

        $userAttributes = [
            'photo_id' => data_get($attributes, 'photo_id'),
            'name' => str_replace('  ', ' ',
                data_get($attributes, 'first_name') . ' ' .
                data_get($attributes, 'middle_name') . ' ' .
                data_get($attributes, 'last_name')
            ),
        ];
        repository(User::class)->update($student->user, $userAttributes);

        $student->bio = $this->getBio($student);

        return $student->update();
    }

    public function getBio(Student $student)
    {
        return '';
    }

    public function filterBySchool($students, School $school): Collection
    {
        if (is_array($students)) {
            $students = collect($students);
        } elseif (! ($students instanceof Collection)) {
            throw new \InvalidArgumentException('Expected array or collection.');
        }

        $ids = $students->map(function ($student) {
            if ($student instanceof Student) {
                return $student->getKey();
            }

            return (int) $student;
        })->toArray();

        return \DB::table('students')
                ->select('id')
                ->whereSchoolId($school->getKey())
                ->whereIn('id', $ids)
                ->get()->pluck('id');
    }
}
