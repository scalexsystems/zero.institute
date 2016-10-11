<?php namespace Scalex\Zero\Observers;

use Scalex\Zero\Models\Student;

class StudentObserver
{
    public function created(Student $student) {
        cache()->forget(schoolify('stats.people'));
    }

    public function deleted(Student $student) {
        cache()->forget(schoolify('stats.people'));
    }
}
