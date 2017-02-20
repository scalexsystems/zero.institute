<?php

namespace Scalex\Zero\Policies;

use Scalex\Zero\User;
use Scalex\Zero\Models\CourseSession;
use Scalex\Zero\Models\Teacher;
use Illuminate\Auth\Access\HandlesAuthorization;

class CourseSessionPolicy
{
    use HandlesAuthorization;

    protected function isInstructor($instructor, CourseSession $session)
    {
        return $instructor instanceof Teacher
               and $instructor->getKey() === (int)$session->instructor_id;
    }

    public function viewEnrolledStudents(User $user, CourseSession $session)
    {
        return $this->isInstructor($user->person, $session) or $session->group->isMember($user);
    }

    /**
     * Determine whether the user can update the session.
     *
     * @param  \Scalex\Zero\User $user
     * @param  \Scalex\Zero\Session $session
     *
     * @return mixed
     */
    public function update(User $user, CourseSession $session)
    {
        return $this->isInstructor($user->person, $session);
    }

    /**
     * Determine whether the user can enroll students.
     *
     * @param  \Scalex\Zero\User $user
     * @param  \Scalex\Zero\Session $session
     *
     * @return mixed
     */
    public function enroll(User $user, CourseSession $session)
    {
        return $this->isInstructor($user->person, $session);
    }

    /**
     * Determine whether the user can expel students.
     *
     * @param  \Scalex\Zero\User $user
     * @param  \Scalex\Zero\Session $session
     *
     * @return mixed
     */
    public function expel(User $user, CourseSession $session)
    {
        return $this->isInstructor($user->person, $session);
    }
}
