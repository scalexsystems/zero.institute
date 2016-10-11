<?php namespace Scalex\Zero\Policies;

use Scalex\Zero\Action;
use Scalex\Zero\Models\Department;
use Scalex\Zero\User;

class DepartmentPolicy extends AbstractPolicy
{
    public function store(User $user) {
        return trust($user)->to(Action::UPDATE_DEPARTMENT);
    }

    public function update(User $user, Department $department) {
        return trust($user)->to(Action::UPDATE_DEPARTMENT);
    }
}
