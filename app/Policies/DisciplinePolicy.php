<?php namespace Scalex\Zero\Policies;

use Scalex\Zero\Action;
use Scalex\Zero\Models\Discipline;
use Scalex\Zero\Policies\Traits\VerifiesSchool;
use Scalex\Zero\User;

class DisciplinePolicy extends AbstractPolicy
{
    use VerifiesSchool;

    public function store(User $user)
    {
        return trust($user)->to('discipline.create');
    }

    public function update(User $user, Discipline $discipline)
    {
        return $user->school_id === $discipline->school_id and trust($user)->to('discipline.update');
    }
}
