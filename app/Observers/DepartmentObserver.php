<?php namespace Scalex\Zero\Observers;

use Scalex\Zero\Models\Department;

class DepartmentObserver
{
    public function created(Department $department)
    {
        $this->forgetCached();
    }

    public function updated(Department $department)
    {
        $this->forgetCached();
    }

    public function deleted(Department $department)
    {
        $this->forgetCached();
    }

    protected function forgetCached()
    {
        cache()->forget(schoolify('departments'));
    }
}
