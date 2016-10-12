<?php

namespace Scalex\Zero\Policies;

use Scalex\Zero\Action;
use Scalex\Zero\Models\Intent;
use Scalex\Zero\Policies\Traits\VerifiesSchool;
use Scalex\Zero\User;

class IntentPolicy extends AbstractPolicy
{
    use VerifiesSchool;

    public function index(User $user) {
        return $this->canManagePeople($user);
    }

    public function view(User $user, Intent $intent) {
        return $this->canManagePeople($user);
    }

    public function update(User $user, Intent $intent) {
        return $this->canManagePeople($user);
    }

    public function accept(User $user, Intent $intent) {
        return $this->canManagePeople($user);
    }

    public function reject(User $user, Intent $intent) {
        return $this->canManagePeople($user);
    }

    protected function canManagePeople(User $user) {
        return trust($user)->to(Action::MANAGE_PEOPLE);
    }
}
