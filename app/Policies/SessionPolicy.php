<?php namespace Scalex\Zero\Policies;

use Scalex\Zero\Models\Session;
use Scalex\Zero\Policies\Traits\VerifiesSchool;
use Scalex\Zero\User;

class SessionPolicy extends AbstractPolicy
{
    use VerifiesSchool;

    public function store(User $user)
    {
        return trust($user)->to('session.create');
    }

    public function update(User $user, Session $session)
    {
        return $user->school_id === $session->school_id and trust($user)->to('session.update');
    }
}
