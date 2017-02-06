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
        return trust($user)->to(Action::UPDATE_STUDENT) or $this->isHimself($user, $student);
    }

    public function viewAddress(User $user, Student $student)
    {
        return $this->canView($student);
    }

    public function viewGuardian(User $user, Student $student)
    {
        return $this->canView($student);
    }

    public function viewAssociatedUserAccount(User $user, Student $student)
    {
        return $this->canView($student);
    }

    public function readSchoolInfo(User $user, Student $student)
    {
        return $this->canView($student);
    }

    public function readMedicalInfo(User $user, Student $student)
    {
        return $this->canView($student);
    }

    public function readBasicInfo(User $user, Student $student)
    {
        return $this->canView($student);
    }

    protected function canView(Student $student)
    {
        return trust($this->getUser())->to(Action::UPDATE_STUDENT)
               or $this->isHimself($this->getUser(), $student);
    }

    public function updatePhoto(User $user, Student $student)
    {
        return trust($user)->to(Action::UPDATE_STUDENT) or $this->isHimself($user, $student);
    }

    public function invite(User $user)
    {
        return trust($user)->to(Action::INVITE_STUDENT);
    }
}
