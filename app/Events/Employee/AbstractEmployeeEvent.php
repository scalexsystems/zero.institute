<?php namespace Scalex\Zero\Events\Employee;


use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Queue\SerializesModels;
use Scalex\Zero\Models\Employee;

abstract class AbstractEmployeeEvent
{
    use InteractsWithSockets, SerializesModels;

    /**
     * @var \Scalex\Zero\Models\Teacher
     */
    protected $employee;

    public $student_id;

    /**
     * Create event.
     *
     * @param \Scalex\Zero\Models\Employee $employee
     */
    public function __construct(Employee $employee)
    {
        $this->employee = $employee;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return $this->employee->school->getChannel();
    }


}