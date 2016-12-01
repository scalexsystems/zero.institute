<?php namespace Scalex\Zero\Http\Controllers\Api\Users;

use Illuminate\Http\Request;
use Scalex\Zero\Http\Controllers\Controller;

class CurrentUserController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api,web');
    }

    public function index(Request $request) {
        $request->query->set('with', 'person,profilePhoto');

        return $request->user();
    }

    public function update(Request $request) {
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
}
