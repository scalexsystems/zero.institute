<?php

namespace Scalex\Zero\Policies;

use Scalex\Zero\Models\CourseSession;
use Scalex\Zero\User;
use Scalex\Zero\Models\Attendance;
use Scalex\Zero\Policies\Traits\VerifiesSchool;

class AttendancePolicy extends AbstractPolicy
{
    use VerifiesSchool;

    public function view(User $user, CourseSession $session)
    {
        return trust($user)->can('attendance.view') and $session->instructor->id === $user->id;
    }

    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the attendance.
     *
     * @param  \Scalex\Zero\User  $user
     * @param  \Scalex\Zero\Models\Attendance  $attendance
     * @return mixed
     */
    public function update(User $user, Attendance $attendance)
    {
        //
    }

    /**
     * Determine whether the user can delete the attendance.
     *
     * @param  \Scalex\Zero\User  $user
     * @param  \Scalex\Zero\Models\Attendance  $attendance
     * @return mixed
     */
    public function delete(User $user, Attendance $attendance)
    {
        //
    }
}
