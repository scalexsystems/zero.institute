<?php namespace Scalex\Zero\Transformers;

use Scalex\Zero\Models\Teacher;
use Znck\Transformers\Transformer;


class TeacherTransformer extends Transformer
{
    protected $availableIncludes = ['address', 'user'];

    public function show(Teacher $teacher) {
        return [
            'name' => (string)$teacher->name,
            'bio' => (string)$teacher->bio,
            'photo' => attach_url($teacher->profilePhoto) ?? asset('img/placeholder-64.jpg'),
            'has_account' => !is_null($teacher->user),
            'user_id' => $teacher->user->getKey(),

            // Basic Information.
            'email' => (string)($teacher->user->email ?? $teacher->address->email),
            'first_name' => (string)$teacher->first_name,
            'middle_name' => (string)$teacher->middle_name,
            'last_name' => (string)$teacher->last_name,
            'date_of_birth' => iso_date($teacher->date_of_birth),
            'gender' => (string)$teacher->gender,
            'blood_group' => (string)$teacher->blood_group,
            'category' => (string)$teacher->category,
            'religion' => (string)$teacher->religion,
            'language' => (string)$teacher->language,
            'passport' => (string)$teacher->passport,
            'govt_id' => (string)$teacher->govt_id,

            // Related to School.
            'uid' => $teacher->uid,
            'date_of_joining' => iso_date($teacher->date_of_joining),
            'job_title' => (string)$teacher->job_title,
            'specialization' => (string)$teacher->specialization,
            'biometric_id' => (string)$teacher->biometric_id,


            // Qualification
            'education' => (array)$teacher->education,
            'experience' => (array)$teacher->experience,

            // Bank Account Details
            'bank' => (string)$teacher->bank,
            'beneficiary_name' => (string)$teacher->beneficiary_name,
            'bank_account_number' => (string)$teacher->bank_account_number,
            'ifsc_code' => (string)$teacher->ifsc_code,
            'income_tax_id' => (string)$teacher->income_tax_id,

            // Medical Information.
            'is_disabled' => (boolean)$teacher->is_disabled,
            'disability' => (string)$teacher->disability,
            'disease' => (string)$teacher->disease,
            'allergy' => (string)$teacher->allergy,
            'visible_marks' => (string)$teacher->visible_marks,
            'food_habit' => (string)$teacher->food_habit,
            'medical_remarks' => (string)$teacher->medical_remarks,
        ];
    }

    public function index(Teacher $teacher) {
        return [
            'uid' => (string)$teacher->uid,
            'name' => (string)$teacher->name,
            'bio' => (string)$teacher->bio,
            'photo' => attach_url($teacher->profilePhoto) ?? asset('img/placeholder-64.jpg'),
            'department_id' => $teacher->department_id,
        ];
    }

    public function includeUser(Teacher $teacher) {
        return $this->item($teacher->user);
    }

    public function includeAddress(Teacher $teacher) {
        return allow(
            'read-address', $teacher,
            $this->item($teacher->address, transformer($teacher->address)),
            $this->null()
        );
    }
}
