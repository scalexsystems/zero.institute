<?php namespace Scalex\Zero\Policies;

use Scalex\Zero\Action;
use Scalex\Zero\Policies\Traits\VerifiesSchool;
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
    public function view(User $user, School $school)
    {
        return $this->verifySchool($user, $school) and trust($user)->to(Action::VIEW_PRIVATE_SCHOOL_INFO);
    }

    /**
     * Can user view school statistics for people.
     *
     * @param \Scalex\Zero\User $user
     * @param \Scalex\Zero\Models\School $school
     *
     * @return bool
     */
    public function viewPeopleStatistics(User $user, School $school)
    {
        return $this->verifySchool($user, $school) and trust($user)->to(Action::PEOPLE);
    }

    /**
     * Determine whether the user can update the school.
     *
     * @param  \Scalex\Zero\User $user
     * @param  \Scalex\Zero\School $school
     *
     * @return bool
     */
    public function update(User $user, School $school)
    {
        return $this->verifySchool($user, $school) and trust($user)->to(Action::UPDATE_SCHOOL);
    }

    protected function verifySchool(User $user, School $school)
    {
        return (int)$user->school_id === $school->getKey();
    }
}
