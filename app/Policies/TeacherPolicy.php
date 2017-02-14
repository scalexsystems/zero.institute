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

    public function viewPhoto()
    {
        return true;
    }

    public function updatePhoto(User $user, Teacher $teacher)
    {
        return $this->canUpdate($user, $teacher);
    }

    public function viewAddress(User $user, Teacher $teacher)
    {
        return $this->canView($teacher);
    }

    public function updateAddress(User $user, Teacher $teacher)
    {
        return $this->canUpdate($user, $teacher);
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
        return $this->isHimself($this->getUser(), $teacher) or trust($this->getUser())->to('teacher.read');
    }

    public function invite(User $user)
    {
        return trust($user)->to('teacher.invite');
    }

    private function canUpdate(User $user, Teacher $teacher): bool
    {
        return $this->isHimself($user, $teacher) or trust($user)->to('teacher.update');
    }
}
