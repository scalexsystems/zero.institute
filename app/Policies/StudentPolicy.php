<?php

namespace Scalex\Zero\Policies;

use Scalex\Zero\Action;
use Scalex\Zero\Models\Student;
use Scalex\Zero\User;

class StudentPolicy extends AbstractPolicy
{
    protected function isHimself(User $user, Student $student) {
        return !is_null($user->person)
               and $student->getKey() === $user->person->getKey();
    }

    /**
     * Determine whether the user can list students.
     *
     * @param  \Scalex\Zero\User $user
     *
     * @return mixed
     */
    public function index(User $user) {
        return true;
    }

    /**
     * Determine whether the user can view the student.
     *
     * @param  \Scalex\Zero\User $user
     * @param  \Scalex\Zero\Models\Student $student
     *
     * @return mixed
     */
    public function view(User $user, Student $student) {
        \Log::debug(static::class.': CHECK USER CAN SEE '.$student->uid.' ('.trust($user)->to(Action::VIEW_STUDENT).')');
        return trust($user)->to(Action::VIEW_STUDENT)
               or $this->isHimself($user, $student);
    }

    public function readAddress(User $user, Student $student) {
        return $this->view($user, $student);
    }

    public function readParent(User $user, Student $student) {
        return $this->view($user, $student);
    }
}
