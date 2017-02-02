<?php namespace Scalex\Zero\Events\Message;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Scalex\Zero\Models\Message;

class NewMessage implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    protected $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Message $message) {
        $this->message = $message;
    }

    public function broadcastWith() {
        return transform($this->message);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\PresenceChannel|\Illuminate\Broadcasting\PrivateChannel
     */
    public function broadcastOn() {
        return is_null($this->message->intended_for) ?
            $this->message->receiver->getChannel() :
            $this->message->intended->getChannel();
    }
}
