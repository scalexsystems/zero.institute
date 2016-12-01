<?php

namespace Scalex\Zero\Events\Group;

use Illuminate\Broadcasting\Channel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Scalex\Zero\Models\Group;

class MemberLeft implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;


    public $members;

    protected $group;

    /**
     * MemberLeft constructor.
     *
     * @param array|Model $ids
     * @param \Scalex\Zero\Models\Group $group
     */
    public function __construct($ids, Group $group) {
        if ($ids instanceof Model) {
            $this->members = (array)$ids->getKey();
        }
        $this->group = $group;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn() {
        return new PresenceChannel($this->group->getChannelName());
    }

    /**
     * @return \Scalex\Zero\Models\Group
     */
    public function getGroup(): \Scalex\Zero\Models\Group {
        return $this->group;
    }
}
