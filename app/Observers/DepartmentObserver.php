<?php namespace Scalex\Zero\Observers;

use Illuminate\Cache\CacheManager;
use Scalex\Zero\Models\Department;

class DepartmentObserver
{
    /**
     * @var \Illuminate\Cache\CacheManager
     */
    protected $manager;

    public function __construct(CacheManager $manager) {
        $this->manager = $manager;
    }

    public function created(Department $department) {
        $this->forgetCached($department);
    }

    public function updated(Department $department) {
        $this->forgetCached($department);
    }

    public function deleted(Department $department) {
        $this->forgetCached($department);
    }

    protected function forgetCached(Department $department) {
        $this->manager->driver()->forget(
            schoolScopeCacheKey('departments', $department->school_id)
        );
    }
}
