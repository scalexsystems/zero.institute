<?php namespace Scalex\Zero\Observers;

use Illuminate\Cache\CacheManager;
use Scalex\Zero\Models\Teacher;
use Scalex\Zero\Services\PeopleStatisticsService;

class TeacherObserver
{
    /**
     * @var \Illuminate\Cache\CacheManager
     */
    protected $manager;

    public function __construct(CacheManager $manager)
    {
        $this->manager = $manager;
    }

    public function created(Teacher $teacher)
    {
        $this->forgetStatsCache($teacher);
    }

    public function deleted(Teacher $teacher)
    {
        $this->forgetStatsCache($teacher);
    }

    public function updated(Teacher $teacher)
    {
        $teacher->user->name = $teacher->name;
        $teacher->user->save();
    }

    /**
     * @param \Scalex\Zero\Models\Teacher $teacher
     */
    protected function forgetStatsCache(Teacher $teacher)
    {
        $this->manager->driver()->forget(
            (new PeopleStatisticsService($teacher->school_id))->getTeacherCacheKey()
        );
    }
}
