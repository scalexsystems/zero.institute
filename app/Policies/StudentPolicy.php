<?php namespace Scalex\Zero\Policies;

use Scalex\Zero\Action;
use Scalex\Zero\Models\Student;
use Scalex\Zero\Policies\Traits\IsHimself;
use Scalex\Zero\Policies\Traits\VerifiesSchool;
use Scalex\Zero\User;

class StudentPolicy extends AbstractPolicy
{
    use VerifiesSchool, IsHimself;

    public function index(User $user) {
        return true;
    }

    public function view(User $user, Student $student) {
        return trust($user)->to(Action::VIEW_STUDENT) or $this->isHimself($user, $student);
    }

    public function readAddress(User $user, Student $student) {
        return $this->view($user, $student);
    }

    public function readParent(User $user, Student $student) {
        return $this->view($user, $student);
    }

    public function invite(User $user){
        return true;
        return trust($user)->to(Action::INVITE_STUDENT);
    }
}
