<?php namespace Scalex\Zero\Http\Controllers;

use Illuminate\Broadcasting\BroadcastController as LaravelBroadcastController;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Factory as Auth;

class BroadcastController extends LaravelBroadcastController
{
    /**
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function authenticate(Request $request)
    {
        $guards = ['web', 'api'];

        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                $this->auth->shouldUse($guard);

                \Log::debug($guard, [$request]);

                break;
            }
        }

        return parent::authenticate($request);
    }
}
