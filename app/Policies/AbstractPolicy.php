<?php namespace Scalex\Zero\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Str;
use Log;
use Scalex\Zero\Contracts\Database\BelongsToSchool;
use Scalex\Zero\User;

abstract class AbstractPolicy
{
    use HandlesAuthorization;

    /**
     * @var User
     */
    protected $user;

    /**
     * Store $user and check before traits.
     *
     * @param \Scalex\Zero\User $user
     * @param $policy
     * @param null $other
     *
     * @return bool
     */
    public function before(User $user, $policy, $other = null)
    {
        $class = self::class;

        $this->user = $user;

        foreach (class_uses_recursive($class) as $trait) {
            if (method_exists($class, $method = 'before'.class_basename($trait))) {
                if (false === call_user_func_array([$class, $method], func_get_args())) {
                    return false;
                }
            }
        }
    }

    /**
     * Current authenticated user.
     *
     * @return \Scalex\Zero\User
     */
    protected function getUser () {
        return $this->user;
    }
}
