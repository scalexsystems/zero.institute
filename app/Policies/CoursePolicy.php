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
        return $this->checkSchool($course);
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('course.create');
    }

    public function update(User $user, Course $course)
    {
        return $user->hasPermissionTo('course.update') and $this->checkSchool($course);
    }

    public function delete(User $user, Course $course)
    {
        return $user->hasPermissionTo('course.delete') and $this->checkSchool($course);
    }

    public function viewInstructors(User $user, Course $course)
    {
        return trust($user)->is('course-admin') or (
                $user->person_type === 'teacher' and !is_null($course->instructors->find($user->person_id))
            );
    }

    protected function checkSchool(Course $course)
    {
        return $this->getUser()->school_id === $course->school_id;
    }
}
