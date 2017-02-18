<?php

namespace Scalex\Zero\Policies;

use Scalex\Zero\User;

class RolePolicy extends AbstractPolicy
{
    public function view(User $user)
    {
        return trust($user)->can('manage_roles');
    }

    public function update(User $user)
    {
        return trust($user)->can('manage_roles');
    }
}
