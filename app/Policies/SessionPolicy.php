<?php

namespace Scalex\Zero\Policies;

use Scalex\Zero\User;
use Scalex\Zero\Models\Session;
use Illuminate\Auth\Access\HandlesAuthorization;

class SessionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the session.
     *
     * @param  \Scalex\Zero\User  $user
     * @param  \Scalex\Zero\Models\Session  $session
     * @return mixed
     */
    public function view(User $user, Session $session)
    {
        //
    }

    /**
     * Determine whether the user can create sessions.
     *
     * @param  \Scalex\Zero\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the session.
     *
     * @param  \Scalex\Zero\User  $user
     * @param  \Scalex\Zero\Models\Session  $session
     * @return mixed
     */
    public function update(User $user, Session $session)
    {
        //
    }

    /**
     * Determine whether the user can delete the session.
     *
     * @param  \Scalex\Zero\User  $user
     * @param  \Scalex\Zero\Models\Session  $session
     * @return mixed
     */
    public function delete(User $user, Session $session)
    {
        //
    }
}
