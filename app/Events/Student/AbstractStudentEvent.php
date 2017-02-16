<?php

namespace Scalex\Zero\Events\Student;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Scalex\Zero\Models\Student;

abstract class AbstractStudentEvent implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    /**
     * @var \Scalex\Zero\Models\Student
     */
    protected $student;

    public $id;

    public $uid;

    public $user_id;

    /**
     * Create event.
     *
     * @param \Scalex\Zero\Models\Student $student
     */
    public function __construct(Student $student)
    {
        $this->student = $student;
        $this->user_id = $student->user->id;
        $this->id = $student->getKey();
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
