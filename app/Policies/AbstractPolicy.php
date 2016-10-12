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
        $class = self::class;
        foreach (class_uses_recursive($class) as $trait) {
            if (method_exists($class, $method = 'before'.class_basename($trait))) {
                if (false === call_user_func_array([$class, $method], func_get_args())) {
                    return false;
                }
            }
        }
    }
}
