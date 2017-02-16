<?php

namespace Scalex\Zero\Events\Student;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Scalex\Zero\Events\Event;
use Scalex\Zero\Models\Student;

abstract class AbstractStudentEvent extends Event
{
    /**
     * @var \Scalex\Zero\Models\Student
     */
    public $student;

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
     * @param \Scalex\Zero\Models\Student $student
     */
    public function __construct(Student $student)
    {
        $this->student = $student;
        $this->user = $student->user;
        $this->uid = $student->getRouteKey();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return $this->student->school->getChannel();
    }
}
