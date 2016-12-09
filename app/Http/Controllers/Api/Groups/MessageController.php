<?php namespace Scalex\Zero\Http\Controllers\Api\Groups;

use Illuminate\Http\Request;
use Scalex\Zero\Criteria\MessageIntendedFor;
use Scalex\Zero\Criteria\MessageSentTo;
use Scalex\Zero\Criteria\OrderBy;
use Scalex\Zero\Events\NewMessage;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\Group;
use Scalex\Zero\Models\Message;

class MessageController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api,web');
    }

    /**
     * Get messages in the group.
     * GET /groups/{group}/messages
     * Requires: auth
     */
    public function index(Group $group, Request $request) {
        $this->authorize('messages', $group);

        return repository(Message::class)
            ->pushCriteria(new MessageSentTo($group))
            ->pushCriteria(new MessageIntendedFor($request->user()))
            ->pushCriteria(new OrderBy('id', 'desc'))
            ->pushCriteria(criteria(function ($query) use ($request) {
                /** @var \Illuminate\Database\Query\Builder $query */
                $query->where('id', '<', (int)$request->input('before', 2147483647));
            }))
            ->with(['attachments', 'sender', 'userReadAt'])
            ->paginate();
    }

    /**
     * Send message to group.
     * POST /groups/{group}/messages
     * Requires: auth
     */
    public function store(Group $group, Request $request) {
        $this->authorize('send', $group);

        $message = repository(Message::class)->create(
            [
                'sender' => $request->user(),
                'sender_id' => $request->user()->id,
                'receiver' => $group,
                'type' => 'text',
                'content' => $request->input('content'),
            ] + $request->except('intended_for'));
        broadcast(new NewMessage($message))->toOthers();

        return $message;
    }


    /**
     * Mark message as read.
     * PUT /groups/{group}/messages/{message}/read
     * Requires: auth
     */
    public function read(Request $request, $group, Message $message = null) {
        if (is_null($message)) {
            $message = $group;
        }
        if (!$message->receiver instanceof Group) {
            abort(404);
        }

        $this->authorize('read', $message->receiver);

        if ($message->intended_for and (int)$message->intended_for !== $request->user()->getKey()) {
            abort(401);
        }

        if ((int)$message->sender_id === $request->user()->getKey()) {
            return $this->accepted();
        }

        if (!is_null($message->userReadAt)) {
            abort(400, 'Message already marked read.');
        }

        if ($message->userReadAt()->create($request->user()) !== true) {
            abort(500);
        }

        return $this->accepted();
    }

}
