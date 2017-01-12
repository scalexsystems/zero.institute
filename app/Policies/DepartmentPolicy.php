<?php namespace Scalex\Zero\Policies;

use Scalex\Zero\Action;
use Scalex\Zero\Models\Department;
use Scalex\Zero\Policies\Traits\VerifiesSchool;
use Scalex\Zero\User;

class DepartmentPolicy extends AbstractPolicy
{
    use VerifiesSchool;

    public function store(User $user) {
        return true;
//        return trust($user)->to(Action::UPDATE_DEPARTMENT);
    }

    public function update(User $user, Department $department) {
        return trust($user)->to(Action::UPDATE_DEPARTMENT);
    }
}
