<?php namespace Scalex\Zero\Policies;

use Scalex\Zero\Action;
use Scalex\Zero\Models\Employee;
use Scalex\Zero\Policies\Traits\IsHimself;
use Scalex\Zero\Policies\Traits\VerifiesSchool;
use Scalex\Zero\User;

class EmployeePolicy extends AbstractPolicy
{
    use VerifiesSchool, isHimself;

    public function browse(User $user)
    {
        return true;
    }

    public function view(User $user)
    {
        return true;
    }

    public function update(User $user, Employee $employee)
    {
        return $this->canUpdate($user, $employee);
    }

    public function viewPhoto()
    {
        return true;
    }

    public function updatePhoto(User $user, Employee $employee)
    {
        return trust($user)->to(Action::VIEW_EMPLOYEE) or $this->isHimself($user, $employee);
    }

    public function viewAddress(User $user, Employee $employee)
    {
        return $this->canView($employee);
    }

    public function viewAssociatedUserAccount(User $user, Employee $employee)
    {
        return $this->canView($employee);
    }

    public function readSchoolInfo(User $user, Employee $employee)
    {
        return $this->canView($employee);
    }

    public function readMedicalInfo(User $user, Employee $employee)
    {
        return $this->canView($employee);
    }

    public function readBasicInfo(User $user, Employee $employee)
    {
        return $this->canView($employee);
    }

    public function readQualificationInfo(User $user, Employee $employee)
    {
        return $this->canView($employee);
    }

    public function readBankAccountInfo(User $user, Employee $employee)
    {
        return $this->canView($employee);
    }

    protected function canView(Employee $employee)
    {
        return trust($this->getUser())->to(Action::UPDATE_EMPLOYEE)
        or $this->isHimself($this->getUser(), $employee);
    }

    public function invite(User $user)
    {
        return trust($user)->to(Action::INVITE_STUDENT);
    }

    private function canUpdate($user, $employee)
    {
        return $this->isHimself($user, $employee) or trust($user)->to(Action::UPDATE_EMPLOYEE);
    }
}
