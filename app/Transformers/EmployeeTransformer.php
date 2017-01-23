<?php namespace Scalex\Zero\Transformers;

use Scalex\Zero\Models\Employee;
use Znck\Transformers\Transformer;

class EmployeeTransformer extends Transformer
{
    protected $availableIncludes = ['address', 'user'];

    public function show(Employee $employee)
    {
        return [
            'name' => (string)$employee->name,
            'bio' => (string)$employee->bio,
            'photo' => attach_url($employee->profilePhoto) ?? asset('img/placeholder.jpg'),
            'has_account' => !is_null($employee->user),
            'user_id' => $employee->user->getKey(),
            'department_id' => (int)$employee->department_id,

            // Basic Information.
            'email' => (string) ($employee->user->email ?? $employee->address->email),
            'first_name' => (string)$employee->first_name,
            'middle_name' => (string)$employee->middle_name,
            'last_name' => (string)$employee->last_name,
            'date_of_birth' => iso_date($employee->date_of_birth),
            'gender' => (string)$employee->gender,
            'blood_group' => (string)$employee->blood_group,
            'category' => (string)$employee->category,
            'religion' => (string)$employee->religion,
            'language' => (string)$employee->language,
            'passport' => (string)$employee->passport,
            'govt_id' => (string)$employee->govt_id,

            // Related to School.
            'uid' => $employee->uid,
            'date_of_joining' => iso_date($employee->date_of_joining),
            'job_title' => (string)$employee->job_title,
            'biometric_id' => (string)$employee->biometric_id,


            // Qualification
            'education' => (array)$employee->education,
            'experience' => (array)$employee->experience,

            // Bank Account Details
            'bank' => (string)$employee->bank,
            'beneficiary_name' => (string)$employee->beneficiary_name,
            'bank_account_number' => (string)$employee->bank_account_number,
            'ifsc_code' => (string)$employee->ifsc_code,
            'income_tax_id' => (string)$employee->income_tax_id,

            // Medical Information.
            'is_disabled' => (boolean)$employee->is_disabled,
            'disability' => (string)$employee->disability,
            'disease' => (string)$employee->disease,
            'allergy' => (string)$employee->allergy,
            'visible_marks' => (string)$employee->visible_marks,
            'food_habit' => (string)$employee->food_habit,
            'medical_remarks' => (string)$employee->medical_remarks,
        ];
    }

    public function index(Employee $employee)
    {
        return [
            'uid' => (string)$employee->uid,
            'name' => (string)$employee->name,
            'bio' => (string)$employee->bio,
            'photo' => attach_url($employee->profilePhoto) ?? asset('img/placeholder-64.jpg'),
            'department_id' => (int)$employee->department_id,
        ];
    }

    public function includeUser(Employee $employee)
    {
        return $this->item($employee->user);
    }

    public function includeAddress(Employee $employee)
    {
        return allow(
            'read-address', $employee,
            $this->item($employee->address),
            $this->null()
        );
    }
}
