<?php namespace Scalex\Zero\Events\Message;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Scalex\Zero\Models\Message;

class Created extends AbstractMessageEvent
{
    public function broadcastWith()
    {
        return transform($this->message);
    }
}
