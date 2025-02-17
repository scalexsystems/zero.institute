<?php namespace Scalex\Zero\Observers;

use Illuminate\Cache\CacheManager;
use Scalex\Zero\Models\Employee;
use Scalex\Zero\Services\PeopleStatisticsService;

class EmployeeObserver
{
    /**
     * @var \Illuminate\Cache\CacheManager
     */
    protected $manager;

    public function __construct(CacheManager $manager)
    {
        $this->manager = $manager;
    }

    public function created(Employee $employee)
    {
        $this->forgetStatsCache($employee);
    }

    public function deleted(Employee $employee)
    {
        $this->forgetStatsCache($employee);
    }

    public function updated(Employee $employee)
    {
        $employee->user->name = $employee->name;
        $employee->user->save();
    }

    /**
     * @param \Scalex\Zero\Models\Employee $employee
     */
    protected function forgetStatsCache(Employee $employee)
    {
        $this->manager->driver()->forget(
            (new PeopleStatisticsService($employee->school_id))->getEmployeeCacheKey()
        );
    }
}
