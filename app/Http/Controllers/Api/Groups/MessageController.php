<?php namespace Scalex\Zero\Http\Controllers\Api\Groups;

use Illuminate\Http\Request;
use Illuminate\Support\Debug\Dumper;
use Scalex\Zero\Criteria\Message\MessageBeforeTimestamp;
use Scalex\Zero\Criteria\Message\MessageIntendedFor;
use Scalex\Zero\Criteria\Message\MessageSentTo;
use Scalex\Zero\Criteria\OrderBy;
use Scalex\Zero\Events\Message\Created;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\Group;
use Scalex\Zero\Models\Message;
use Carbon\Carbon;
use Scalex\Zero\Repositories\MessageRepository;

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
     * List all messages in the group.
     *
     * @param \Scalex\Zero\Models\Group $group
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index(Group $group, Request $request, MessageRepository $repository)
    {
        $this->authorize('view-messages', $group);

        $messages = $repository
            ->pushCriteria(new MessageSentTo($group))
            ->pushCriteria(new MessageBeforeTimestamp($request->input('timestamp', time())))
            ->pushCriteria(new OrderBy('id', 'desc'))
            ->with(['attachments', 'sender'])
            ->paginate();

        return $repository->loadMessageStatesFor($messages, $request->user());
    }

    /**
     * Send message to group.
     *
     * @param \Scalex\Zero\Models\Group $group
     * @param \Illuminate\Http\Request $request
     * @param \Scalex\Zero\Repositories\MessageRepository $repository
     *
     * @return \Scalex\Zero\Models\Message
     */
    public function store(Group $group, Request $request, MessageRepository $repository)
    {
        $this->authorize('send-message', $group);

        $message = $repository->createWithGroup($group, $request->all(), $request->user());
        $repository->read($message, $request->user());

        broadcast(new Created($message));

        return $message;
    }
}
