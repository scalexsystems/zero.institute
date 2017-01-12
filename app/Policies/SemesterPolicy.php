<?php

namespace Scalex\Zero\Policies;

use Scalex\Zero\Policies\Traits\VerifiesSchool;
use Scalex\Zero\User;
use Scalex\Zero\Models\Semester;
use Illuminate\Auth\Access\HandlesAuthorization;

class SemesterPolicy
{
    use VerifiesSchool;

    public function store(User $user) {
        return verify_school($user);
//        return trust($user)->to(Action::UPDATE_DEPARTMENT);
    }

    public function update(User $user, Semester $semester) {
        return verify_school($user);
//        return trust($user)->to(Action::UPDATE_DEPARTMENT);
    }

}

