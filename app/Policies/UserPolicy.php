<?php namespace Scalex\Zero\Policies;

use Scalex\Zero\User;

class UserPolicy extends AbstractPolicy
{
    public function readEmail(User $user, User $resource) {
        return $user->getKey() === $resource->getKey();
    }

    public function readAccount(User $user, User $resource) {
        return $user->getKey() === $resource->getKey();
    }

    public function isAdmin(User $user)
    {
        return trust($user)->is('admin');
    }
}
