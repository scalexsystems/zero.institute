<?php namespace Scalex\Zero\Policies;

use Scalex\Zero\Action;
use Scalex\Zero\Policies\Traits\VerifiesSchool;
use Scalex\Zero\User;

class DisciplinePolicy extends AbstractPolicy
{
    use VerifiesSchool;

    public function store(User $user) {
        return verify_school($user);
//        return trust($user)->to(Action::UPDATE_DISCIPLINE);
    }

    public function update(User $user) {
        return verify_school($user);
//        return trust($user)->to(Action::UPDATE_DISCIPLINE);
    }
}
