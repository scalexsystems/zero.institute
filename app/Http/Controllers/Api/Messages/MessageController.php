<?php namespace Scalex\Zero\Http\Controllers\Api\Messages;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Scalex\Zero\Criteria\Message\Direct\ConversationBetween;
use Scalex\Zero\Criteria\OrderBy;
use Scalex\Zero\Events\Message\NewMessage;
use Scalex\Zero\Events\Message\MessageRead;
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
     * Update message state.
     *
     * @param \Scalex\Zero\Models\Message $message
     *
     * @return \Illuminate\Http\Response
     */
    public function read(Request $request, Message $message, MessageRepository $repository)
    {
        $this->authorize('read', $message);

        $state = $repository->read($message, $request->user());

        broadcast(new MessageRead($state));

        return $this->accepted();
    }

    /**
     * Mark messages as read in bulk.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Scalex\Zero\Repositories\MessageRepository $repository
     *
     * @return \Illuminate\Http\Response
     */
    public function readAll(Request $request, MessageRepository $repository)
    {
        $this->validate($request, ['messages' => 'required']);

        $messages = $repository->with('receiver')->findMany((array)$request->input('messages'));
        $messages->each(function ($message) {
            $this->authorize('read', $message);
        });

        $states = $repository->readAll($messages, $request->user());

        broadcast(new MessageRead($states));

        return $this->accepted();
    }
}
