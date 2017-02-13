<?php namespace Scalex\Zero\Http\Controllers\Api\Messages;

use Illuminate\Http\Request;
use Scalex\Zero\Criteria\Message\Direct\HaveConversationWith;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Http\Requests;
use Scalex\Zero\Repositories\UserRepository;
use Scalex\Zero\Transformers\UserTransformer;
use Scalex\Zero\User;

class CurrentUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api,web');
    }

    /**
     * Get messaged users for current user.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Scalex\Zero\Repositories\UserRepository $repository
     *
     * @return mixed
     */
    public function index(Request $request, UserRepository $repository)
    {
        $request->query->set('with', 'person');

        $users = $repository->with(['person', 'photo'])
                          ->pushCriteria(new HaveConversationWith($request->user()))
                          ->paginate();

        return transform($users, ['person'], null, true);
    }

    /**
     * Get user by ID.
     *
     * @param \Scalex\Zero\User $user
     *
     * @return \Scalex\Zero\User
     */
    public function show(User $user, UserTransformer $transformer)
    {
        return transform($user, ['person'], null, true);
    }
}
