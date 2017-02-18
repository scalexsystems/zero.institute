<?php namespace Scalex\Zero\Policies;

use Scalex\Zero\Action;
use Scalex\Zero\Models\Department;
use Scalex\Zero\Policies\Traits\VerifiesSchool;
use Scalex\Zero\User;

class DepartmentPolicy extends AbstractPolicy
{
    use VerifiesSchool;

    public function store(User $user)
    {
        return trust($user)->to('department.create');
    }

    public function update(User $user, Department $department)
    {
        return $user->school_id === $department->school_id and trust($user)->to('department.update');
    }
}
