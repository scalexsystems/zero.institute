<?php namespace Scalex\Zero\Observers;

use Scalex\Zero\Models\Teacher;

class TeacherObserver
{
    public function created(Teacher $teacher) {
        cache()->forget(schoolify('stats.people'));
    }

    public function deleted(Teacher $teacher) {
        cache()->forget(schoolify('stats.people'));
    }
}
