<?php namespace Scalex\Zero\Transformers;

use Gate;
use Scalex\Zero\Models\Employee;
use Znck\Transformers\Transformer;

class EmployeeTransformer extends Transformer
{
    protected $availableIncludes = ['address', 'user'];

    public function index(Employee $employee)
    {
        return $this->getPublicInfo($employee);
    }

    public function show(Employee $employee)
    {
        return $this->getPublicInfo($employee)
        + $this->getBasicInfo($employee)
        + $this->getMedicalInfo($employee)
        + $this->getSchoolRelatedInfo($employee)
        + $this->getQualificationInfo($employee)
        + $this->getBankAccountInfo($employee);
    }

    public function getPublicInfo(Employee $employee)
    {
        return [
            'name' => (string)$employee->name,
            'bio' => (string)$employee->bio,
            'photo' => attach_url($employee->profilePhoto) ?? asset('img/placeholder-64.jpg'),
            'has_account' => !is_null($employee->user),
            'user_id' => $employee->user ? $employee->user->getKey() : null,
            'department_id' => (int)$employee->department_id,
            'uid' => (int)$employee->uid,
        ];
    }

    public function getBasicInfo(Employee $employee) : array
    {
        if (Gate::denies('read-basic-info', $employee)) {
            return [];
        }

        return [
            'email' => (string)($employee->user->email ?? $employee->address->email),
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
        ];

    }

    public function getSchoolRelatedInfo(Employee $employee)
    {
        if (Gate::denies('read-school-info', $employee)) {
            return [];
        }

        return [
            'uid' => $employee->uid,
            'date_of_joining' => iso_date($employee->date_of_joining),
            'job_title' => (string)$employee->job_title,
            'specialization' => (string)$employee->specialization,
            'biometric_id' => (string)$employee->biometric_id,
        ];
    }


    public function getQualificationInfo(Employee $employee)
    {
        if (Gate::denies('read-qualification-info', $employee)) {
            return [];
        }

        return [
            'education' => (array)$employee->education,
            'experience' => (array)$employee->experience,
        ];
    }

    public function getBankAccountInfo(Employee $employee)
    {
        if (Gate::denies('read-bank-account-info', $employee)) {
            return [];
        }

        return [
            'bank' => (string)$employee->bank,
            'beneficiary_name' => (string)$employee->beneficiary_name,
            'bank_account_number' => (string)$employee->bank_account_number,
            'ifsc_code' => (string)$employee->ifsc_code,
            'income_tax_id' => (string)$employee->income_tax_id,
        ];
    }

    public function getMedicalInfo(Employee $employee)
    {
        if (Gate::denies('read-medical-info', $employee)) {
            return [];
        }

        return [
            'is_disabled' => (boolean)$employee->is_disabled,
            'disability' => (string)$employee->disability,
            'disease' => (string)$employee->disease,
            'allergy' => (string)$employee->allergy,
            'visible_marks' => (string)$employee->visible_marks,
            'food_habit' => (string)$employee->food_habit,
            'medical_remarks' => (string)$employee->medical_remarks,
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
