<?php
use Scalex\Zero\Models\Course;
use Scalex\Zero\Models\CourseSession;

/**
 * Created by PhpStorm.
 * User: dpc
 * Date: 24/2/17
 * Time: 5:06 PM
 */
trait CourseSessionTestHelper
{

    public function createCourse($count = 0)
    {
        $school = $this->getSchool();

        $override = ['school_id' => $school->id ];

        return factory(Course::class, $count)->create($override);

    }

    public function createCourseWithSession($count = 0)
    {
        $course = $this->createCourse($count);
        return factory(CourseSession::class)->create(['course_id' => $course->id]);

    }



}