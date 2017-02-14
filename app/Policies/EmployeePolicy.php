<?php namespace Scalex\Zero\Policies;

use Scalex\Zero\Action;
use Scalex\Zero\Models\Employee;
use Scalex\Zero\Policies\Traits\IsHimself;
use Scalex\Zero\Policies\Traits\VerifiesSchool;
use Scalex\Zero\User;

class EmployeePolicy extends AbstractPolicy
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
        return $this->canUpdate($user, $employee);
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
        return $this->isHimself($this->getUser(), $employee) or trust($this->getUser())->to('employee.read');
    }

    public function invite(User $user)
    {
        return trust($user)->to('employee.invite');
    }

    private function canUpdate(User $user, Employee $employee)
    {
        return $this->isHimself($user, $employee) or trust($user)->to('employee.update');
    }
}
