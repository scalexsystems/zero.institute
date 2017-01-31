<?php namespace Scalex\Zero\Policies;

use Scalex\Zero\Action;
use Scalex\Zero\Models\Teacher;
use Scalex\Zero\Policies\Traits\IsHimself;
use Scalex\Zero\Policies\Traits\VerifiesSchool;
use Scalex\Zero\User;

class TeacherPolicy extends AbstractPolicy
{
    use VerifiesSchool, IsHimself;

    public function index(User $user)
    {
        return true;
    }

    public function view(User $user, Teacher $teacher)
    {
        return trust($user)->to(Action::VIEW_TEACHER) or $this->isHimself($user, $teacher);
    }

    public function update(User $user, Teacher $teacher)
    {
        return trust($user)->to(Action::UPDATE_TEACHER) or $this->isHimself($user, $teacher);
    }

    public function updatePhoto(User $user, Teacher $teacher)
    {
        return trust($user)->to(Action::VIEW_TEACHER) or $this->isHimself($user, $teacher);
    }

    public function readAddress(User $user, Teacher $teacher)
    {
        return $this->view($user, $teacher);
    }
    public function invite(User $user)
    {
        return trust($user)->to(Action::INVITE_STUDENT);
    }
}
