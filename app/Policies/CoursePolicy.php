<?php

namespace Scalex\Zero\Policies;

use Scalex\Zero\User;
use Scalex\Zero\Models\Course;
use Scalex\Zero\Action;

class CoursePolicy extends AbstractPolicy
{
    public function index(User $user)
    {
        return true;
    }

    public function view(User $user, Course $course)
    {
        return verify_school($course);
    }

    public function store(User $user)
    {
        return $user->hasPermissionTo(Action::CREATE_COURSE);
    }

    public function update(User $user, Course $course)
    {
        return ($user->id === $course->instructor_id)
            or ($user->hasPermissionTo(Action::UPDATE_COURSE) and verify_school($course));
    }

    public function delete(User $user, Course $course)
    {
        return $user->hasPermissionTo(Action::DELETE_COURSE) and verify_school($course);
    }
}
