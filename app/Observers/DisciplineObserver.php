<?php namespace Scalex\Zero\Observers;

use Scalex\Zero\Models\Discipline;

class DisciplineObserver
{
    public function created(Discipline $discipline) {
        $this->forgetCached();
    }

    public function updated(Discipline $discipline) {
        $this->forgetCached();
    }

    public function deleted(Discipline $discipline) {
        $this->forgetCached();
    }

    protected function forgetCached() {
        cache()->forget(schoolify('disciplines'));
    }
}
