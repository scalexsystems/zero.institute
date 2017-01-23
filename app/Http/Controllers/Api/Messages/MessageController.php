<?php namespace Scalex\Zero\Http\Controllers\Api\Messages;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Scalex\Zero\Criteria\MessageBetween;
use Scalex\Zero\Criteria\OrderBy;
use Scalex\Zero\Events\NewMessage;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\Message;
use Scalex\Zero\User;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api,web');
    }

    /**
     * Get messages from the user.
     * GET /messages/users/{user}
     * Required: auth
     */
    public function index(Request $request, User $user)
    {
        return repository(Message::class)
            ->pushCriteria(new MessageBetween($user, $request->user()))
            ->pushCriteria(new OrderBy('id', 'desc'))
            ->pushCriteria(criteria(function ($query) use ($request) {
                /** @var \Illuminate\Database\Query\Builder $query */
                $query->where('id', '<', (int)$request->input('before', 2147483647));
            }))
            ->with(['attachments', 'sender'])
            ->paginate();
    }

    /**
     * Send message to user.
     * POST /messages/users/{user}
     * Required: auth
     */
    public function store(Request $request, User $user)
    {
        $message = repository(Message::class)->create(
            [
                'sender' => $request->user(),
                'sender_id' => $request->user()->id,
                'receiver' => $user,
                'type' => 'text',
                'content' => $request->input('content'),
            ] + $request->except('intended_for'));

        event(new NewMessage($message));

        return $message;
    }

    /**
     * Mark message as read.
     * POST /messages/{message}/read
     * Required: auth
     */
    public function read(Message $message)
    {
        $this->authorize('read', $message);

        if (is_null($message->read_at)) {
            $message->read_at = Carbon::now();
            repository($message)->update($message, []);
        }

        return $this->accepted();
    }
}
