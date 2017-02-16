<?php namespace Scalex\Zero\Events\CourseSession;

use Scalex\Zero\Events\Event;
use Scalex\Zero\Models\CourseSession;

abstract class AbstractCourseSessionEvent extends Event
{
    /**
     * @var \Scalex\Zero\Models\CourseSession
     */
    protected $courseSession;

    /**
     * @var \Scalex\Zero\Models\Teacher
     */
    protected $teacher;

    /**
     * @var \Scalex\Zero\Models\Session
     */
    protected $session;

    /**
     * @var \Scalex\Zero\Models\Course
     */
    protected $course;

    public function __construct(CourseSession $courseSession)
    {
        $this->courseSession = $courseSession;
        $this->course = $courseSession->course;
        $this->session = $courseSession->session;
        $this->teacher = $courseSession->instructor;
    }
}
