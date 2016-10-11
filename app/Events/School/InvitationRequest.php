<?php namespace Scalex\Zero\Events\School;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Queue\SerializesModels;

class InvitationRequest
{
    use InteractsWithSockets, SerializesModels;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $email;

    public function __construct(string $name, string $email) {
        $this->name = $name;
        $this->email = $email;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn() {
        return new PrivateChannel('zero:invitations');
    }
}
