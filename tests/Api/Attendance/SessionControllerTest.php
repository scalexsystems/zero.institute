<?php namespace Tests\Api\Attendance;

use TestCase;
use Tests\Api\People\Students\StudentTestHelper;
use Tests\Api\People\Teachers\TeacherTestHelper;

class SessionControllerTest extends TestCase
{
    use StudentTestHelper, AttendanceTestHelper, TeacherTestHelper;

    public function test_index_can_get_attendance_for_a_session()
    {
        $attendance = $this->markAttendanceForSessionAndStudent(2);

        $session = $attendance->first()->load('course_session')->course_session;

        $teacher = $this->createTeacherAndUser();
        $this->addInstructorTo($session, $teacher);

        $this->givePermissionTo($teacher->user, 'attendance.view');

        $this->actingAs($teacher->user)->get('api/sessions/'. $session->id . '/attendances')
            ->assertStatus(200)
            ->assertJsonStructure(['attendances' => []]);

    }

    public function test_index_shows_no_attendances_for_other_teachers()
    {
        $attendance = $this->markAttendanceForSessionAndStudent();

        $teacher = $this->createTeacherAndUser();

        $session = $attendance->first()->load('course_session')->course_session;

        $this->givePermissionTo($teacher->user, 'attendance.view');

        $this->actingAs($teacher->user)->get('api/sessions/' . $session->id . '/attendances')
            ->assertStatus(401);

    }

    public function test_store_can_take_attendance()
    {
        $teacher = $this->createTeacherAndUser();

        $students = $this->createStudent(2);

        $session = $this->createCourseWithSession();

        $this->addInstructorTo($session->first(), $teacher);

        $this->actingAs($teacher->user)->post('api/sessions/' . $session->first()->id . '/attendances', [$students->pluck('id')])
            ->assertStatus(202);

    }
}
