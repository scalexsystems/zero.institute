<?php

namespace Scalex\Zero\Events\Message;

use Illuminate\Broadcasting\Channel;
use Scalex\Zero\Events\Event;

class Read extends Event
{
    protected $state;

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
        $state = collect($this->state)->first();

        if ($state) {
            return $state->message->receiver->getChannel();
        }

        return [];
    }
}
