<?php namespace Scalex\Zero\Transformers;

use Gate;
use Scalex\Zero\Models\Student;
use Znck\Transformers\Transformer;

class StudentTransformer extends Transformer
{
    protected $availableIncludes = ['father', 'mother', 'address', 'user'];

    public function index(Student $student)
    {
        return $this->getPublicInfo($student);
    }

    public function show(Student $student)
    {
        return $this->getPublicInfo($student)
               + $this->getBasicInfo($student)
               + $this->getMedicalInfo($student)
               + $this->getSchoolRelatedInfo($student);
    }

    public function includeUser(Student $student)
    {
        if ($student->user and Gate::allows('view-associated-user-account', $student)) {
            return $this->item($student->user);
        }

        return $this->null();
    }

    public function includeAddress(Student $student)
    {
        if ($student->address and Gate::allows('view-address', $student)) {
            return $this->item($student->address);
        }

        return $this->null();
    }

    public function includeFather(Student $student)
    {
        if ($student->father and Gate::allows('view-guardian', $student)) {
            return $this->item($student->father);
        }

        return $this->null();
    }

    public function includeMother(Student $student)
    {
        if ($student->mother and Gate::allows('view-guardian', $student)) {
            return $this->item($student->mother);
        }

        return $this->null();
    }

    /**
     * Get public information.
     *
     * @param \Scalex\Zero\Models\Student $student
     *
     * @return array
     */
    protected function getPublicInfo(Student $student): array
    {
        return [
            'uid' => (string)$student->uid,
            'name' => (string)$student->name,
            'photo' => $student->getPhotoUrl(),

            'department_id' => $student->department_id,
            'discipline_id' => $student->discipline_id,

            'has_account' => !is_null($student->user),
            'user_id' => $student->user ? $student->user->getKey() : null,
        ];
    }

    /**
     * Get school related information.
     *
     * @param \Scalex\Zero\Models\Student $student
     *
     * @return array
     */
    protected function getSchoolRelatedInfo(Student $student): array
    {
        if (Gate::denies('read-school-info', $student)) {
            return [];
        }

        return [
            'uid' => $student->uid,
            'date_of_admission' => iso_date($student->date_of_admission),
            'boarding_type' => (string)$student->boarding_type,
            'year' => $student->year,
            'department_id' => $student->department_id,
            'discipline_id' => $student->discipline_id,
            'biometric_id' => (string)$student->biometric_id,
        ];
    }

    /**
     * Get medical information.
     *
     * @param \Scalex\Zero\Models\Student $student
     *
     * @return array
     */
    protected function getMedicalInfo(Student $student): array
    {
        if (Gate::denies('read-medical-info', $student)) {
            return [];
        }

        return [
            'blood_group' => (string)$student->blood_group,
            'is_disabled' => (boolean)$student->is_disabled,
            'disability' => (string)$student->disability,
            'disease' => (string)$student->disease,
            'allergy' => (string)$student->allergy,
            'visible_marks' => (string)$student->visible_marks,
            'food_habit' => (array)$student->food_habit,
            'medical_remarks' => (string)$student->medical_remarks,
        ];
    }

    /**
     * Get basic information.
     *
     * @param \Scalex\Zero\Models\Student $student
     *
     * @return array
     */
    protected function getBasicInfo(Student $student): array
    {
        if (Gate::denies('read-basic-info', $student)) {
            return [];
        }

        return [
            'email' => $this->getEmail($student),
            'first_name' => (string)$student->first_name,
            'middle_name' => (string)$student->middle_name,
            'last_name' => (string)$student->last_name,
            'gender' => (string)$student->gender,
            'category' => (string)$student->category,
            'religion' => (string)$student->religion,
            'language' => (string)$student->language,
            'passport' => (string)$student->passport,
            'govt_id' => (string)$student->govt_id,
            'date_of_birth' => iso_date($student->date_of_birth),

            'mother_id' => $student->mother_id,
            'father_id' => $student->father_id,
        ];
    }

    /**
     * @param \Scalex\Zero\Models\Student $student
     *
     * @return string
     */
    protected function getEmail(Student $student): string
    {
        if ($student->address) {
            return (string) $student->address->email;
        }

        if ($student->user) {
            return (string) $student->user->email;
        }

        return '';
    }
}
