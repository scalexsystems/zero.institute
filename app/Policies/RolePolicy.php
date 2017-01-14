<?php

namespace Scalex\Zero\Policies;

use Scalex\Zero\Policies\Traits\VerifiesSchool;
use Scalex\Zero\User;
use Znck\Trust\Models\Role;

class RolePolicy
{
    use VerifiesSchool;

    /**
     * Determine whether the user can view the role.
     *
     * @param  \Scalex\Zero\User  $user
     * @param  \Scalex\Zero\Role  $role
     * @return mixed
     */
    public function view(User $user, Role $role)
    {
        //
    }

    /**
     * Determine whether the user can create roles.
     *
     * @param  \Scalex\Zero\User  $user
     * @return mixed
     */
    public function store(User $user)
    {
        return true;
        $this->verifySchool($user);
    }

    /**
     * Determine whether the user can update the role.
     *
     * @param  \Scalex\Zero\User  $user
     * @param  \Scalex\Zero\Role  $role
     * @return mixed
     */
    public function update(User $user, Role $role)
    {
        //
    }

    /**
     * Determine whether the user can delete the role.
     *
     * @param  \Scalex\Zero\User  $user
     * @param  \Scalex\Zero\Role  $role
     * @return mixed
     */
    public function delete(User $user, Role $role)
    {
        //
    }
}
