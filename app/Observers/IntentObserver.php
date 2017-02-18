<?php namespace Scalex\Zero\Observers;

use Scalex\Zero\Models\Intent;

class IntentObserver
{
    public function created(Intent $intent)
    {
        if (hash_equals('account', $intent->tag)) {
            cache()->forget(schoolScopeCacheKey('stats.accounts'));
        }
    }

    public function deleted(Intent $intent)
    {
        if (hash_equals('account', $intent->tag)) {
            cache()->forget(schoolScopeCacheKey('stats.accounts'));
        }
    }
}
