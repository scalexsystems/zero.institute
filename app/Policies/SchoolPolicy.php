<?php namespace Scalex\Zero\Policies;

use Scalex\Zero\Action;
use Scalex\Zero\User;
use Scalex\Zero\Models\School;
use Illuminate\Auth\Access\HandlesAuthorization;

class SchoolPolicy extends AbstractPolicy
{
    /**
     * Determine whether the user can view the school.
     *
     * @param  \Scalex\Zero\User $user
     * @param  \Scalex\Zero\School $school
     *
     * @return bool
     */
    public function view(User $user, School $school) {
        return trust($user)->to(Action::VIEW_PRIVATE_SCHOOL_INFO);
    }

    /**
     * Determine whether the user can update the school.
     *
     * @param  \Scalex\Zero\User $user
     * @param  \Scalex\Zero\School $school
     *
     * @return bool
     */
    public function update(User $user, School $school) {
        return trust($user)->to(Action::UPDATE_SCHOOL);
    }
}
