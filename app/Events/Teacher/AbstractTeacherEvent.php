<?php namespace Scalex\Zero\Events\Teacher;


use Scalex\Zero\Models\Teacher;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AbstractTeacherEvent implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    /**
     * @var \Scalex\Zero\Models\Teacher
     */
    protected $teacher;

    public $id;

    public $uid;

    public $user_id;

    /**
     * Create event.
     *
     * @param \Scalex\Zero\Models\Teacher $teacher
     */
    public function __construct(Teacher $teacher)
    {
        $this->teacher = $teacher;
        $this->user_id = $teacher->user->id;
        $this->id = $teacher->getKey();
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