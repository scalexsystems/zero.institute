<?php

namespace Scalex\Zero\Http\Controllers\Api\Attendance;

use Illuminate\Http\Request;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\Attendance;
use Scalex\Zero\Models\Course;
use Scalex\Zero\Models\CourseSession;
use Scalex\Zero\Models\Student;
use Scalex\Zero\Repositories\AttendanceRepository;

class StatisticsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api,web');
    }

    public function index(Request $request, AttendanceRepository $repository)
    {
        $this->authorize('view-attendance-report', CourseSession::class);
        $semester = $request->input('semester', null);
        $course = $request->input('course', null);
        $month = $request->month;

        $user = $request->user();

        return [ 'attendances' => $repository->getAttendanceAggregate($user, $semester, $course, $month)];
    }

    public function show(Request $request, AttendanceRepository $repository, Course $course)
    {

        $this->authorize('view-attendance-report', CourseSession::class);

        return ['attendances' => $repository->getAttendanceAggregateForCourse($course)];



    }
}
