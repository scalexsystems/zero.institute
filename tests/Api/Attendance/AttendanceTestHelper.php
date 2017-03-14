<?php namespace Tests\Api\Attendance;

use Scalex\Zero\Models\Attendance;
use Scalex\Zero\Models\Course;
use Scalex\Zero\Models\CourseSession;
use Scalex\Zero\Models\Teacher;

/**
 * Created by PhpStorm.
 * User: dpc
 * Date: 24/2/17
 * Time: 5:06 PM
 */
trait AttendanceTestHelper
{

    public function createCourse($count = 1)
    {
        $school = $this->getSchool();

        $override = ['school_id' => $school->id ];

        return factory(Course::class, $count)->create($override);

    }

    public function createCourseWithSession($count = 1)
    {
        return factory(CourseSession::class, $count)->create();
    }

    public function markAttendanceForSessionAndStudent($count = 1)
    {
        return factory(Attendance::class, $count)->create();

    }

    public function addInstructorTo(CourseSession $session, Teacher $teacher)
    {
        $session->instructor()->associate($teacher);
        $session->save();
        return $session;
    }



}