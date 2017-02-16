<?php namespace Scalex\Zero\Events\Teacher;


use Illuminate\Broadcasting\Channel;
use Scalex\Zero\Events\Event;
use Scalex\Zero\Models\Teacher;

class AbstractTeacherEvent extends Event
{
    /**
     * @var \Scalex\Zero\Models\Teacher
     */
    public $teacher;

    /**
     * @var \Scalex\Zero\User
     */
    public $user;

    /**
     * @var string
     */
    public $uid;

    /**
     * Create event.
     *
     * @param \Scalex\Zero\Models\Teacher $teacher
     */
    public function __construct(Teacher $teacher)
    {
        $this->teacher = $teacher;
        $this->user = $teacher->user;
        $this->uid = $teacher->getRouteKey();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return $this->teacher->school->getChannel();
    }

}