<?php namespace Scalex\Zero\Policies;

use Scalex\Zero\Action;
use Scalex\Zero\User;
use Scalex\Zero\Models\School;
use Illuminate\Auth\Access\HandlesAuthorization;

class SchoolPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the school.
     *
     * @param  \Scalex\Zero\User $user
     * @param  \Scalex\Zero\School $school
     *
     * @return bool
     */
    public function view(User $user, School $school) {
        return verify_school($user, $school) and trust($user)->to(Action::READ_SCHOOL_PRIVATE_INFO);
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
        \Log::debug('VERIFY USER CAN UPDATE');
        
        return verify_school($user, $school) and trust($user)->to(Action::UPDATE_SCHOOL);
    }
}
