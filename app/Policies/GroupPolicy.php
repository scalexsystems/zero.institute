<?php

namespace Scalex\Zero\Policies;

use Scalex\Zero\User;
use Scalex\Zero\Models\Group;
use Illuminate\Auth\Access\HandlesAuthorization;

class GroupPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the group.
     *
     * @param  Scalex\Zero\User  $user
     * @param  Scalex\Zero\Group  $group
     * @return mixed
     */
    public function view(User $user, Group $group)
    {
        //
    }

    /**
     * Determine whether the user can create groups.
     *
     * @param  Scalex\Zero\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the group.
     *
     * @param  Scalex\Zero\User  $user
     * @param  Scalex\Zero\Group  $group
     * @return mixed
     */
    public function update(User $user, Group $group)
    {
        //
    }

    /**
     * Determine whether the user can delete the group.
     *
     * @param  Scalex\Zero\User  $user
     * @param  Scalex\Zero\Group  $group
     * @return mixed
     */
    public function delete(User $user, Group $group)
    {
        //
    }
}
