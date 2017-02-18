<?php namespace Scalex\Zero\Policies;

use Scalex\Zero\Action;
use Scalex\Zero\Models\Student;
use Scalex\Zero\Policies\Traits\IsHimself;
use Scalex\Zero\Policies\Traits\VerifiesSchool;
use Scalex\Zero\User;

class StudentPolicy extends AbstractPolicy
{
    use VerifiesSchool, IsHimself;

    public function browse(User $user)
    {
        return true; // NOTE: Permissions are taken care of in transformer.
    }

    public function view(User $user, Student $student)
    {
        return true; // NOTE: Permissions are taken care of in transformer.
    }

    public function update(User $user, Student $student)
    {
        return $this->canUpdate($user, $student);
    }

    public function viewAddress(User $user, Student $student)
    {
        return $this->canView($user, $student);
    }

    public function updateAddress(User $user, Student $student)
    {
        return $this->canUpdate($user, $student);
    }

    public function viewPhoto()
    {
        return true;
    }

    public function updatePhoto(User $user, Student $student)
    {
        return $this->canUpdate($user, $student);
    }

    public function viewGuardian(User $user, Student $student)
    {
        return $this->canView($user, $student);
    }

    public function updateGuardian(User $user, Student $student)
    {
        return $this->canUpdate($user, $student);
    }

    public function viewAssociatedUserAccount(User $user, Student $student)
    {
        return $this->canView($user, $student);
    }

    public function readSchoolInfo(User $user, Student $student)
    {
        return $this->canView($user, $student);
    }

    public function readMedicalInfo(User $user, Student $student)
    {
        return $this->canView($user, $student);
    }

    public function readBasicInfo(User $user, Student $student)
    {
        return $this->canView($user, $student);
    }

    public function sendInvitation(User $user)
    {
        return trust($user)->to('student.invite');
    }

    /**
     * Can update any information?
     *
     * @param \Scalex\Zero\User $user
     * @param \Scalex\Zero\Models\Student $student
     *
     * @return bool
     */
    protected function canUpdate(User $user, Student $student): bool
    {
        return $this->isHimself($user, $student) or trust($user)->to('student.update');
    }

    /**
     * Can view any information?
     *
     * @param \Scalex\Zero\User $user
     * @param \Scalex\Zero\Models\Student $student
     *
     * @return bool
     */
    protected function canView(User $user, Student $student): bool
    {
        return $this->isHimself($user, $student) or trust($user)->to('student.read');
    }
}
