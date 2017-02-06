<?php namespace Scalex\Zero\Observers;

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
