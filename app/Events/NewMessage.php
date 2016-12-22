<?php namespace Scalex\Zero\Events;

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
        return ['read_at' => null, 'unread' => true] + transform($this->message);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn() {
        return $this->message->receiver->getChannel();
    }
}
