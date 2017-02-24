<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Test\Api\Attendance\AttendanceTestHelper;
use Test\Api\People\Students\StudentTestHelper;

class SessionControllerTest extends TestCase
{
    use StudentTestHelper, AttendanceTestHelper;

    public function test_index_can_get_attendance_for_a_session()
    {
        $student = $this->createStudentAndUser();




    }




}
