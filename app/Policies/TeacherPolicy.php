<?php namespace Scalex\Zero\Policies;

use Scalex\Zero\Action;
use Scalex\Zero\Models\Teacher;
use Scalex\Zero\User;

class TeacherPolicy extends AbstractPolicy
{
    protected function isHimself(User $user, Teacher $teacher) {
        return !is_null($user->person) and $teacher->getKey() === $user->person->getKey();
    }

    public function index(User $user) {
        return true;
    }

    public function view(User $user, Teacher $teacher) {
        return trust($user)->to(Action::VIEW_TEACHER) or $this->isHimself($user, $teacher);
    }

    public function readAddress(User $user, Teacher $teacher) {
        return $this->view($user, $teacher);
    }
}
