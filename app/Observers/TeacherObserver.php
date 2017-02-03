<?php namespace Scalex\Zero\Observers;

use Scalex\Zero\Models\Teacher;

class TeacherObserver
{
    /**
     * @var \Illuminate\Cache\CacheManager
     */
    protected $manager;

    public function __construct(CacheManager $manager) {
        $this->manager = $manager;
    }

    public function created(Teacher $teacher) {
        $this->forgetStatsCache($teacher);
    }

    public function deleted(Teacher $teacher) {
        $this->forgetStatsCache($teacher);
    }

    /**
     * @param \Scalex\Zero\Models\Teacher $teacher
     */
    protected function forgetStatsCache(Teacher $teacher):void {
        $this->manager->driver()->forget(
            schoolScopeCacheKey('stats.people', $teacher->school_id)
        );
    }
}
