<?php namespace Scalex\Zero\Observers;

use Illuminate\Cache\CacheManager;
use Scalex\Zero\Models\Discipline;

class DisciplineObserver
{
    /**
     * @var \Illuminate\Cache\CacheManager
     */
    protected $manager;

    public function __construct(CacheManager $manager) {
        $this->manager = $manager;
    }

    public function created(Discipline $discipline) {
        $this->forgetCached($discipline);
    }

    public function updated(Discipline $discipline) {
        $this->forgetCached($discipline);
    }

    public function deleted(Discipline $discipline) {
        $this->forgetCached($discipline);
    }

    protected function forgetCached(Discipline $discipline) {
        $this->manager->driver()->forget(
            schoolScopeCacheKey('disciplines', $discipline->school_id)
        );
    }
}
