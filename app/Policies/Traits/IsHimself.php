<?php namespace Scalex\Zero\Policies\Traits;

use Scalex\Zero\User;

trait IsHimself
{

    /**
     * @param \Scalex\Zero\User $user
     * @param \Scalex\Zero\Contracts\Person $person
     *
     * @return bool
     */
    protected function isHimself(User $user, $person)
    {
        return !is_null($user->person) and $person->id === $user->person->getKey();
    }
}
