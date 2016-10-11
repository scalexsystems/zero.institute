<?php namespace Scalex\Zero\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Str;
use Log;
use Scalex\Zero\Contracts\Database\BelongsToSchool;
use Scalex\Zero\User;

abstract class AbstractPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $policy, $other = null) {
        if ($other instanceof BelongsToSchool) {
            Log::debug(class_basename(static::class).': ('.$policy.') Verify '.Str::lower(class_basename(get_class($other))).' belongs to school. ('.json_encode(verify_school($other)).')');
            if (!verify_school($other)) {
                return false;
            }
        }
    }
}
