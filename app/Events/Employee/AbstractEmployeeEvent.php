<?php namespace Scalex\Zero\Events\Employee;


use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Scalex\Zero\Events\Event;
use Scalex\Zero\Models\Employee;

abstract class AbstractEmployeeEvent extends Event
{
    /**
     * @var \Scalex\Zero\Models\Teacher
     */
    public $employee;

    /**
     * @var \Scalex\Zero\User
     */
    public $user;

    /**
     * @var string
     */
    public $uid;

    public function __construct(Employee $employee)
    {
        $this->employee = $employee;
        $this->user = $employee->user;
        $this->uid = $employee->getRouteKey();
    }

    public function broadcastOn()
    {
        return [$this->employee->school->getChannel()];
    }
}