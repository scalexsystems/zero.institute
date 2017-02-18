<?php namespace Scalex\Zero\Observers;

use Illuminate\Cache\CacheManager;
use Scalex\Zero\Models\Student;
use Scalex\Zero\Services\PeopleStatisticsService;

class StudentObserver
{
    /**
     * @var \Illuminate\Cache\CacheManager
     */
    protected $manager;

    public function __construct(CacheManager $manager)
    {
        $this->manager = $manager;
    }

    public function created(Student $student)
    {
        $this->forgetStatsCache($student);
    }

    public function deleted(Student $student)
    {
        $this->forgetStatsCache($student);
    }

    /**
     * @param \Scalex\Zero\Models\Student $student
     */
    protected function forgetStatsCache(Student $student)
    {
        $this->manager->driver()->forget(
            (new PeopleStatisticsService($student->school_id))->getStudentCacheKey()
        );
    }
}
