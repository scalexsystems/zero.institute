<?php namespace Scalex\Zero\Repositories;

use Illuminate\Database\Eloquent\Model;
use Scalex\Zero\Criteria\OfSchool;
use Scalex\Zero\Models\Attachment;
use Scalex\Zero\Models\Employee;
use Scalex\Zero\Models\Geo\Address;
use Znck\Repositories\Repository;

/**
 * @method Employee find(string|int $id)
 * @method Employee findBy(string $key, $value)
 * @method Employee create(array $attr)
 * @method Employee update(string|int|Employee $id, array $attr, array $o = [])
 * @method Employee delete(string|int|Employee $id)
 * @method EmployeeRepository validate(array $attr, Employee|null $model)
 */
class EmployeeRepository extends Repository
{
    /**
     * Class name of the Eloquent model.
     *
     * @var string
     */
    protected $model = Employee::class;

    /**
     * Validation rules.
     *
     * @var array
     */
    protected $rules = [
        // Basic Information
        'photo_id' => 'nullable|exists:documents,id',
        'first_name' => 'required|max:255',
        'middle_name' => 'nullable|max:255',
        'last_name' => 'required|max:255',
        'date_of_birth' => 'required|date',
        'gender' => 'nullable|in:female,male,other',
        'blood_group' => 'nullable|in:A+,A-,AB+,AB-,B+,B-,O+,O-',
        'category' => 'nullable|in:gen,obc,sc,st,ot',
        'religion' => 'nullable|max:255',
        'language' => 'nullable|max:255',
        'nationality' => 'nullable|max:255',
        'passport' => 'nullable|max:255',
        'govt_id' => 'nullable|max:255',

        // Related to School
        'uid' => 'required|unique:teachers,uid,NULL,id,school_id,',
        'date_of_joining' => 'nullable|date',
        'job_title' => 'nullable|max:255',
        'department_id' => 'required|exists:departments,id',
        'biometric_id' => 'nullable|max:255',

        // Qualification.
        'education' => 'nullable',

        // Past Working Experience.
        'experience' => 'nullable',

        // Address
        'address_id' => 'required|exists:addresses,id',

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
        'food_habit' => 'nullable|in:veg,non_veg',
        'medical_remarks' => 'nullable|max:65536',

        // Maintenance Information
        'archived' => 'nullable|boolean',
        'school_id' => 'required|exists:schools,id',
        'remarks' => 'nullable|max:65536',
    ];

    public function boot()
    {
        if (current_user()) {
            $this->pushCriteria(new OfSchool(current_user()->school));
        }
    }

    public function getRules(array $attributes = [], Model $model = null): array
    {
        $data = parent::getRules($attributes, $model);
        $data['uid'] .= current_user()->school_id;

        return $data;
    }

    /**
     * @param array $rules
     * @param array $attributes
     * @param Employee $employee
     *
     * @return array
     */
    public function getUpdateRules(array $rules, array $attributes, $employee)
    {
        $rules += array_dot(
            [
                'address' => repository(Address::class)->getRules($attributes, $employee->address),
            ]);

        return array_only($rules, array_keys($attributes));
    }

    public function getCreateRules(array $attributes)
    {
        return $this->rules + array_dot(
            [
                'address' => repository(Address::class)->getRules($attributes),
            ]);
    }

    public function creating(Employee $employee, array $attributes)
    {
        $employee->fill($attributes);

        // Start Transaction.
        $this->startTransaction();

        $employee->address()->associate(repository(Address::class)->create(array_get($attributes, 'address', [])));
        $employee->department()->associate(find($attributes, 'department_id'));
        $employee->school()->associate(find($attributes, 'school_id'));
        attach_attachment($employee, 'profilePhoto', find($attributes, 'photo_id', Attachment::class));

        $employee->bio = $this->getBio($employee);

        $status = $employee->save();

        if ($status and $employee->address) {
            $employee->address->addressee()->associate($employee)->save();
        }

        return $status;
    }

    public function updating(Employee $employee, array $attributes)
    {
        $attributes = array_except($attributes, ['date_of_birth', 'date_of_admission']);
        $employee->fill($attributes);

        // Start Transaction.
//        $this->startTransaction();

        if (array_has($attributes, 'address') && !empty($attributes['address'])) {
            if (isset($employee->address)) {
                repository(Address::class)
                    ->update($employee->address, $attributes['address']);

            } else {
                $employee->address()->associate(repository(Address::class)->create(array_get($attributes, 'address', [])));
            }
        }
        if (array_has($attributes, 'department_id')) {
            $employee->department()->associate(find($attributes, 'department_id'));


        }
        if (array_has($attributes, 'photo_id')) {
            attach_attachment($employee, 'profilePhoto', find($attributes, 'photo_id', Attachment::class));
        }

        $employee->bio = $this->getBio($employee);
        return $employee->update();
    }

    public function getBio(Employee $employee)
    {
        return $employee->job_title.' ・ '
               .($employee->department->short_name ?? $employee->department->name);
    }
}
