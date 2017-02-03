<?php namespace Scalex\Zero\Observers;

class SemesterObserver
{
    public function created()
    {
        cache()->forget(schoolScopeCacheKey('semesters'));
    }

    public function deleted()
    {
        cache()->forget(schoolScopeCacheKey('semesters'));
    }

    public function updated()
    {
        cache()->forget(schoolScopeCacheKey('semesters'));
    }
}
