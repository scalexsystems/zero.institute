<?php namespace Scalex\Zero\Http\Controllers\Api\Messages;

use Illuminate\Http\Request;
use Scalex\Zero\Criteria\UserHasSentMessageTo;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Http\Requests;
use Scalex\Zero\User;

class CurrentUserController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api,web');
    }

    /**
     * Get list of users who have sent any message to current user.
     * GET /me/messages/users
     * Required: auth
     */
    public function index(Request $request) {
        $request->query->set('with', 'person');
        $users = repository(User::class)->with(['person', 'profilePhoto', 'lastMessageAt']);

        if ($request->has('id')) {
            return $users->findMany([(int)$request->query('id')]);
        }

        return $users->pushCriteria(new UserHasSentMessageTo($request->user()))
                     ->paginate();
    }
}
