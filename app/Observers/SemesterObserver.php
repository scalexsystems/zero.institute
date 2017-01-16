<?php namespace Scalex\Zero\Observers;

class SemesterObserver
{
    public function created() {
        cache()->forget(schoolify('semesters'));
    }

    public function deleted() {
        cache()->forget(schoolify('semesters'));
    }

    public function updated() {
        cache()->forget(schoolify('semesters'));
    }
}
