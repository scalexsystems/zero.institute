<?php namespace Scalex\Zero\Policies\Traits;

/**
 * Class VerifiesSchool
 *
 * @package Scalex\Zero\Policies\Traits
 *
 * @help set `$skipSchoolVerification` to `true`, to disable before verification.
 */
trait VerifiesSchool
{
    public function beforeVerifiesSchool(User $user, $policy, $other = null) {
        if (isset($this->skipSchoolVerification) and $this->skipSchoolVerification === true) return;

        \Log::debug('VERIFY SCHOOL');

        return $this->verifySchool($other);
    }

    /**
     * @param mixed $model
     * @param \Scalex\Zero\Models\School|null $school
     *
     * @return bool
     */
    protected function verifySchool($model, $school = null):bool {
        return verify_school($model, $school);
    }
}
