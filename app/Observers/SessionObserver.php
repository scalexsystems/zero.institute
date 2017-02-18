<?php namespace Scalex\Zero\Observers;

use Illuminate\Cache\CacheManager;
use Scalex\Zero\Models\Session;

class SessionObserver
{
    /**
     * @var \Illuminate\Cache\CacheManager
     */
    protected $manager;

    public function __construct(CacheManager $manager)
    {
        $this->manager = $manager;
    }

    public function created(Session $session)
    {
        $this->forgetCached($session);
    }

    public function updated(Session $session)
    {
        $this->forgetCached($session);
    }

    public function deleted(Session $session)
    {
        $this->forgetCached($session);
    }

    protected function forgetCached(Session $session)
    {
        $this->manager->driver()->forget(
            schoolScopeCacheKey('sessions', $session->school_id)
        );
    }
}
