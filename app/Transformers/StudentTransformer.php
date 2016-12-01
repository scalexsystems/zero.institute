<?php namespace Scalex\Zero\Transformers;

use Scalex\Zero\Models\Student;
use Znck\Transformers\Transformer;


class StudentTransformer extends Transformer
{
    protected $availableIncludes = ['father', 'mother', 'address', 'user'];

    public function show(Student $student) {
        return [
            'name' => (string)$student->name,
            'bio' => (string)$student->bio,
            'photo' => attach_url($student->profilePhoto) ?? asset('img/placeholder-64.jpg'),
            'has_account' => !is_null($student->user),

            // Basic Information.
            'email' => (string)($student->user->email ?? $student->address->email),
            'first_name' => (string)$student->first_name,
            'middle_name' => (string)$student->middle_name,
            'last_name' => (string)$student->last_name,
            'date_of_birth' => iso_date($student->date_of_birth),
            'gender' => (string)$student->gender,
            'blood_group' => (string)$student->blood_group,
            'category' => (string)$student->category,
            'religion' => (string)$student->religion,
            'language' => (string)$student->language,
            'passport' => (string)$student->passport,
            'govt_id' => (string)$student->govt_id,


            // Parents
            'mother_id' => $student->mother_id,
            'father_id' => $student->father_id,

            // Related to School.
            'uid' => $student->uid,
            'date_of_admission' => iso_date($student->date_of_admission),
            'boarding_type' => (string)$student->boarding_type,
            'year' => $student->date_of_admission->year ?? null,
            'department_id' => $student->department_id,
            'discipline_id' => $student->discipline_id,
            'biometric_id' => (string)$student->biometric_id,

            // Medical Information.
            'is_disabled' => (boolean)$student->is_disabled,
            'disability' => (string)$student->disability,
            'disease' => (string)$student->disease,
            'allergy' => (string)$student->allergy,
            'visible_marks' => (string)$student->visible_marks,
            'food_habit' => (string)$student->food_habit,
            'medical_remarks' => (string)$student->medical_remarks,
        ];
    }

    public function includeUser(Student $student) {
        return $this->item($student->user);
    }

    public function index(Student $student) {
        return [
            'uid' => (string)$student->uid,
            'name' => (string)$student->name,
            'bio' => (string)$student->bio,
            'photo' => attach_url($student->profilePhoto) ?? asset('img/placeholder-64.jpg'),
            'department_id' => $student->department_id,
            'discipline_id' => $student->discipline_id,
        ];
    }

    public function includeAddress(Student $student) {
        return allow(
            'read-address', $student,
            $this->item($student->address, transformer($student->address)),
            $this->null()
        );
    }

    public function includeFather(Student $student) {
        return allow(
            'read-parent', $student,
            $this->item($student->father, transformer($student->father)),
            $this->null()
        );
    }

    public function includeMother(Student $student) {
        return allow(
            'read-parent', $student,
            $this->item($student->mother, transformer($student->mother)),
            $this->null()
        );
    }
}
