<?php namespace Scalex\Zero\Policies;

use Scalex\Zero\Models\Semester;
use Scalex\Zero\Policies\Traits\VerifiesSchool;
use Scalex\Zero\User;

class SemesterPolicy extends AbstractPolicy
{
    use VerifiesSchool;

    public function store(User $user)
    {
        return trust($user)->to('semester.create');
    }

    public function update(User $user, Semester $semester)
    {
        return $user->school_id === $semester->school_id and trust($user)->to('semester.update');
    }
}
