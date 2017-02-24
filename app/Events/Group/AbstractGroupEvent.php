<?php namespace Scalex\Zero\Events\Group;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Scalex\Zero\Events\Event;
use Scalex\Zero\Models\Group;

abstract class AbstractGroupEvent extends Event
{
    /**
     * Send event to school.
     *
     * @var bool
     */
    protected $toSchool = false;

    /**
     * Send event to group.
     *
     * @var bool
     */
    protected $toGroup = true;

    /**
     * Group for the event.
     *
     * @var \Scalex\Zero\Models\Group
     */
    public $group;

    /**
     * AbstractGroupEvent constructor.
     *
     * @param $group
     */
    public function __construct(Group $group)
    {
        $this->group = $group;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        $channels = collect();

        if ($this->toSchool and $this->group->school) {
            $channels->push($this->group->school->getChannel());
        }

        if ($this->toGroup) {
            $channels->push($this->group->getChannel());
        }

        if (!$channels->count()) {
            return (array)parent::broadcastOn();
        }

        return $channels->toArray();
    }
}
