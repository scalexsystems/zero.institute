<?php namespace Scalex\Zero\Events\Course;

use Scalex\Zero\Events\Event;
use Scalex\Zero\Models\Course;

abstract class AbstractCourseEvent extends Event
{
    public $course;

    public function __construct(Course $course)
    {
        $this->course = $course;
    }

    public function broadcastOn()
    {
        return [$this->course->school->getChannel()];
    }
}
