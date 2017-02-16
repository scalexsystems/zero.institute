<?php

namespace Scalex\Zero\Http\Controllers\Api\Messages\Direct;

use Illuminate\Http\Request;
use Scalex\Zero\Criteria\Message\Direct\ConversationBetween;
use Scalex\Zero\Criteria\Message\MessageBeforeTimestamp;
use Scalex\Zero\Criteria\OrderBy;
use Scalex\Zero\Events\Message\NewMessage;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\Message;
use Scalex\Zero\Repositories\MessageRepository;
use Scalex\Zero\User;

class MessageController extends Controller
{
    /**
     * Add auth middleware to all routes.
     */
    public function __construct()
    {
        $this->middleware('auth:api,web');
    }

    /**
     * Get messages between current user and the provided user.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Scalex\Zero\User $user
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index(Request $request, User $user, MessageRepository $repository)
    {
        $this->authorize('view-conversation', $user);

        $messages = $repository
            ->pushCriteria(new ConversationBetween($user, $request->user()))
            ->pushCriteria(new MessageBeforeTimestamp($request->input('timestamp', time())))
            ->pushCriteria(new OrderBy('id', 'desc'))
            ->with(['attachments', 'sender'])
            ->paginate();

        return $repository->loadMessageStatesFor($messages, $request->user());
    }

    /**
     * Send message to the user.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Scalex\Zero\User $user
     * @param \Scalex\Zero\Repositories\MessageRepository $repository
     *
     * @return \Scalex\Zero\Models\Message
     */
    public function store(Request $request, User $user, MessageRepository $repository)
    {
        $this->authorize('send-message', $user);

        $message = $repository->createWithUser($user, $request->all(), $request->user());
        $repository->read($message, $request->user());

        broadcast(new NewMessage($message));

        return $message;
    }
}
