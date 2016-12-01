<?php namespace Scalex\Zero\Repositories;

use Illuminate\Database\Eloquent\Model;
use Scalex\Zero\Criteria\OfSchool;
use Scalex\Zero\Models\Attachment;
use Scalex\Zero\Models\Geo\Address;
use Scalex\Zero\Models\Guardian;
use Scalex\Zero\Models\Student;
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
    use \Znck\Repositories\Traits\RepositoryHelper;

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
        'photo_id' => 'nullable|exists:documents,id',
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

    public function boot() {
        if (current_user()) {
            $this->pushCriteria(new OfSchool(current_user()->school));
        }
    }

    public function getRules(array $attributes, Model $model = null): array {
        $data = parent::getRules($attributes, $model);
        $data['uid'] .= current_user()->school_id;

        return $data;
    }

    /**
     * @param array $rules
     * @param array $attributes
     * @param Student $student
     *
     * @return array
     */
    public function getUpdateRules(array $rules, array $attributes, $student) {
        $rules += array_dot(
            [
                'address' => repository(Address::class)->getRules($attributes, $student->address),
                'mother' => repository(Guardian::class)->getRules($attributes, $student->mother),
                'father' => repository(Guardian::class)->getRules($attributes, $student->father),
            ]);

        return array_only($rules, array_keys($attributes));
    }

    public function getCreateRules(array $attributes) {
        $guardianRules = repository(Guardian::class)->getRules($attributes);

        return $this->rules + array_dot(
            [
                'address' => repository(Address::class)->getRules($attributes),
                'mother' => $guardianRules,
                'father' => $guardianRules,
            ]);
    }

    public function creating(Student $student, array $attributes) {
        $student->fill($attributes);

        // Start Transaction.
        $this->startTransaction();

        $student->address()->associate(repository(Address::class)->create(array_get($attributes, 'address', [])));
        $student->department()->associate(find($attributes, 'department_id'));
        $student->discipline()->associate(find($attributes, 'discipline_id'));
        $student->father()->associate(find($attributes, 'father_id', Guardian::class));
        $student->mother()->associate(find($attributes, 'mother_id', Guardian::class));
        $student->school()->associate(find($attributes, 'school_id'));
        attach_attachment($student, 'profilePhoto', find($attributes, 'photo_id', Attachment::class));

        $student->created(once(function (Student $student) {
            $student->address->addressee()->associate($student)->save();
        }));

        $student->bio = $this->getBio($student);

        return $student->save();
    }

    public function updating(Student $student, array $attributes) {
        $student->fill($attributes);

        // Start Transaction.
        $this->startTransaction();

        if (array_has($attributes, 'address')) {
            repository(Address::class)
                ->update($student->address, $attributes['address']);
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
        if (array_has($attributes, 'father_id')) {
            $student->father()->associate(find($attributes, 'father_id', Guardian::class));
        }
        if (array_has($attributes, 'mother_id')) {
            $student->mother()->associate(find($attributes, 'mother_id', Guardian::class));
        }

        $student->bio = $this->getBio($student);

        return $student->update();
    }

    public function getBio(Student $student) {
        return 'Student ・ '
               .($student->department->short_name ?? $student->department->name).' '
               .$student->date_of_admission->year;
    }
}
