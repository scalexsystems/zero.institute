<?php

namespace Scalex\Zero\Events\User;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Scalex\Zero\Models\Intent;

class AccountIntentSubmitted implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;
    /**
     * @var \Scalex\Zero\Models\Intent
     */
    public $intent;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Intent $intent)
    {
        $this->intent = $intent;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel(schoolScopeCacheKey('accounts'));
    }
}
