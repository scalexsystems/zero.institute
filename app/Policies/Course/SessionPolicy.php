<?php

namespace Scalex\Zero\Policies\Course;

use Scalex\Zero\User;
use Scalex\Zero\Models\Course\Session;
use Scalex\Zero\Models\Teacher;
use Illuminate\Auth\Access\HandlesAuthorization;

class SessionPolicy
{
    use HandlesAuthorization;

    protected function isInstructor($instructor, Session $session)
    {
        return $instructor instanceof Teacher
            and $instructor->getKey() === (int) $session->instructor_id;
    }

    /**
     * Determine whether the user can update the session.
     *
     * @param  \Scalex\Zero\User  $user
     * @param  \Scalex\Zero\Session  $session
     * @return mixed
     */
    public function enroll(User $user, Session $session)
    {
        return $this->isInstructor($user->person, $session);
    }

    /**
     * Determine whether the user can delete the session.
     *
     * @param  \Scalex\Zero\User  $user
     * @param  \Scalex\Zero\Session  $session
     * @return mixed
     */
    public function deroll(User $user, Session $session)
    {
        return $this->isInstructor($user->person, $session);
    }
}
