<?php

namespace Scalex\Zero\Events\Messages;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Scalex\Zero\Models\Message\MessageState;

class MessageRead
{
    use InteractsWithSockets, SerializesModels;

    /**
     * @var \Scalex\Zero\Models\Message\MessageState|\Illuminate\Database\Eloquent\Collection
     */
    protected $state;

    /**
     * MessageRead constructor.
     *
     * @param \Scalex\Zero\Models\Message\MessageState|\Illuminate\Database\Eloquent\Collection $state
     */
    public function __construct($state)
    {
        $this->state = $state;
    }

    /**
     * Event payload.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return transform($this->state, null, null, true);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return collect($this->state)->first()->message->receiver->getChannel();
    }
}
