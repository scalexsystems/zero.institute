<?php namespace Scalex\Zero\Events\Message;

use Scalex\Zero\Events\Event;
use Scalex\Zero\Models\Message;

abstract class AbstractMessageEvent extends Event
{
    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function broadcastOn()
    {
        $message = $this->message;

        return is_null($message->intended_for) ? $message->receiver->getChannel() : $message->intended->getChannel();
    }
}
