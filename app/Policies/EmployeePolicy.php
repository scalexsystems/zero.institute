<?php namespace Scalex\Zero\Policies;

use Scalex\Zero\Action;
use Scalex\Zero\Models\Employee;
use Scalex\Zero\Policies\Traits\VerifiesSchool;
use Scalex\Zero\User;

class EmployeePolicy extends AbstractPolicy
{
    use VerifiesSchool;

    protected function isHimself(User $user, Employee $employee)
    {
        return !is_null($user->person) and $employee->getKey() === $user->person->getKey();
    }

    public function index(User $user)
    {
        return true;
    }

    public function view(User $user, Employee $employee)
    {
        return trust($user)->to(Action::VIEW_EMPLOYEE)
               or $this->isHimself($user, $employee);
    }

    public function readAddress(User $user, Employee $employee)
    {
        return $this->view($user, $employee);
    }

    public function invite(User $user)
    {
        return trust($user)->to(Action::INVITE_EMPLOYEE);
    }
}
