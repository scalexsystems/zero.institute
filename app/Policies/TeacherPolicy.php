<?php namespace Scalex\Zero\Policies;

use Scalex\Zero\Action;
use Scalex\Zero\Models\Teacher;
use Scalex\Zero\Policies\Traits\IsHimself;
use Scalex\Zero\Policies\Traits\VerifiesSchool;
use Scalex\Zero\User;

class TeacherPolicy extends AbstractPolicy
{
    use VerifiesSchool, IsHimself;

    public function browse(User $user)
    {
        return true;
    }

    public function view(User $user)
    {
        return true;
    }

    public function update(User $user, Teacher $teacher)
    {
        return $this->canUpdate($user, $teacher);
    }

    public function updatePhoto(User $user, Teacher $teacher)
    {
        return trust($user)->to(Action::VIEW_TEACHER) or $this->isHimself($user, $teacher);
    }

    public function viewAddress(User $user, Teacher $teacher)
    {
        return $this->canView($teacher);
    }

    public function viewAssociatedUserAccount(User $user, Teacher $teacher)
    {
        return $this->canView($teacher);
    }

    public function readSchoolInfo(User $user, Teacher $teacher)
    {
        return $this->canView($teacher);
    }

    public function readMedicalInfo(User $user, Teacher $teacher)
    {
        return $this->canView($teacher);
    }

    public function readBasicInfo(User $user, Teacher $teacher)
    {
        return $this->canView($teacher);
    }

    public function readQualificationInfo(User $user, Teacher $teacher)
    {
        return $this->canView($teacher);
    }

    public function readBankAccountInfo(User $user, Teacher $teacher)
    {
        return $this->canView($teacher);
    }

    protected function canView(Teacher $teacher)
    {
        return trust($this->getUser())->to(Action::UPDATE_TEACHER)
        or $this->isHimself($this->getUser(), $teacher);
    }

    public function invite(User $user)
    {
        return trust($user)->to(Action::INVITE_STUDENT);
    }

    private function canUpdate($user, $teacher)
    {
        return $this->isHimself($user, $teacher) or trust($user)->to(Action::UPDATE_TEACHER);
    }
}
