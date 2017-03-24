<?php namespace Tests\Api\Attendance;

use TestCase;
use Tests\Api\People\Students\StudentTestHelper;
use Tests\Api\People\Teachers\TeacherTestHelper;

class CurrentUserControllerTest extends TestCase
{
    use StudentTestHelper, AttendanceTestHelper, TeacherTestHelper;

    public function test_index_gets_sessions_for_a_semester_and_student_for_a_teacher()
    {
        $teacher = $this->createTeacherAndUser();

        $student = $this->createStudent();

        $session = $this->createCourseWithSession();

        $this->addInstructorTo($session->first(), $teacher);

        $semester = $session->first()->course->semester;

        $this->actingAs($teacher->user)->get('api/me/semesters/' . $semester->id . '/students/' . $student->uid . '/sessions')
            ->assertStatus(200)
            ->assertJsonStructure(['course_sessions' => []]);

    }
}
