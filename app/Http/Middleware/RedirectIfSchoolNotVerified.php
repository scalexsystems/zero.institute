<?php

namespace Scalex\Zero\Http\Middleware;

use Closure;

class RedirectIfSchoolNotVerified
{
    protected $except = [
        '/setup',
        '/setup/institute*'
    ];
    /**
     * Determine if the request has a URI that should pass through CSRF verification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function shouldPassThrough($request)
    {
        foreach ($this->except as $except) {
            if ($except !== '/') {
                $except = trim($except, '/');
            }

            if ($request->is($except)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ( ! $this->shouldPassThrough($request) and \Auth::check() ) {
            $school = $request->user()->school;

            if ($school->verified !== true) {

                return redirect('/setup');
            }
        }

        return $next($request);
    }
}
