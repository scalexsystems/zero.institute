<?php namespace Scalex\Zero\Policies;

use Scalex\Zero\Models\School;
use Scalex\Zero\User;

class SchoolPolicy extends AbstractPolicy
{
    public function view(User $user, School $school)
    {
        return $this->verifySchool($user, $school);
    }

    public function update(User $user, School $school)
    {
        return $this->verifySchool($user, $school) and trust($user)->to('school.update');
    }

    public function updatePhoto(User $user, School $school)
    {
        return $this->update($user, $school);
    }

    public function updateAddress(User $user, School $school)
    {
        return $this->update($user, $school);
    }

    public function viewPeopleStatistics(User $user, School $school)
    {
        return $this->verifySchool($user, $school) and trust($user)->to('people.statistics');
    }

    protected function verifySchool(User $user, School $school)
    {
        return (int)$user->school_id === $school->getKey();
    }
}
