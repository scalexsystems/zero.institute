<?php

namespace Scalex\Zero\Http\Controllers\Api;

use Illuminate\Http\Request;

use Scalex\Zero\Events\User\UserEmailUpdated;
use Scalex\Zero\Http\Requests;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\User;

class UserController extends Controller
{
    /*
     * Get authenticated user.
     *
     * GET /me
     *
     * Requires: auth
     */
    public function showCurrent(Request $request) {
        $request->query->set('with', 'person,profilePhoto');

        return $request->user();
    }

    /*
     * Update user info.
     *
     * PUT /me
     *
     * Requires: auth
     */
    public function updateCurrent(Request $request) {
        $updatingEmail = $request->has('email');

        $user = repository(User::class)->update(
            $request->user(),
            $request->except('password', 'person')
        );

        if ($updatingEmail) {
            event(new UserEmailUpdated($user));
        }

        return $this->accepted();
    }

    /*
     * Get user dashboard.
     *
     * GET /me/dashboard
     *
     * Requires: auth
     */
    public function dashboard(Request $request) {
        return [
            'apps' => [],
        ];
    }
}
