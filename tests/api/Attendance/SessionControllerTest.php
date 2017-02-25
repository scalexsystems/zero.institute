<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Test\Api\Attendance\AttendanceTestHelper;
use Test\Api\People\Students\StudentTestHelper;
use Test\Api\People\Teachers\TeacherTestHelper;

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
            ->assertResponseStatus(200)
            ->seeJsonStructure('attendances', []);

    }

    public function test_index_shows_no_attendances_for_other_teachers()
    {
        $attendance = $this->markAttendanceForSessionAndStudent();

        $teacher = $this->createTeacherAndUser();

        $session = $attendance->first()->load('course_session')->course_session;

        $this->givePermissionTo($teacher->user, 'attendance.view');

        $this->actingAs($teacher->user)->get('api/sessions/' . $session->id . '/attendances')
            ->assertResponseStatus(401);

    }
}
