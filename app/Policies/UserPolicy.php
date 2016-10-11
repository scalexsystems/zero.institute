<?php

namespace Scalex\Zero\Policies;

use Scalex\Zero\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function readEmail(User $user, User $resource) {
        return $user->getKey() === $resource->getKey();
    }

    public function readAccount(User $user, User $resource) {
        return $user->getKey() === $resource->getKey();
    }
}
