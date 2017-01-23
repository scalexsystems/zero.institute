<?php namespace Scalex\Zero\Observers;

use Scalex\Zero\Models\Employee;

class EmployeeObserver
{
    public function created(Employee $employee)
    {
        cache()->forget(schoolify('stats.people'));
    }

    public function deleted(Employee $employee)
    {
        cache()->forget(schoolify('stats.people'));
    }
}
