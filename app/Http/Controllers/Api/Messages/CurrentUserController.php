<?php namespace Scalex\Zero\Http\Controllers\Api\Messages;

use Illuminate\Http\Request;
use Scalex\Zero\Criteria\Message\Direct\HaveConversationWithMessageCount;
use Scalex\Zero\Criteria\Message\Direct\MessagesCountMultipleUser;
use Scalex\Zero\Criteria\Message\Direct\MessagesCount;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Http\Requests;
use Scalex\Zero\Repositories\UserRepository;
use Scalex\Zero\User;
use Znck\Repositories\Exceptions\NotFoundResourceException;

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

        $repository->with(['person', 'photo'])
                   ->pushCriteria(new HaveConversationWithMessageCount($request->user()));

        $users = $repository->paginate();

        return transform($users, ['person'], null, true);
    }

    /**
     * Get user by ID.
     *
     * @param \Scalex\Zero\User $user
     *
     * @return \Scalex\Zero\User
     */
    public function show($user, UserRepository $repository, Request $request)
    {
        if ($request->user()->id === (int)$user) {
            return transform($request->user(), ['person'], null, true);
        }

        try {
            $user = $repository->pushCriteria(new HaveConversationWithMessageCount($request->user()))->find($user);
        } catch (NotFoundResourceException $e) {
            $user = User::findOrFail($user);
        }

        return transform($user, ['person'], null, true);
    }
}
