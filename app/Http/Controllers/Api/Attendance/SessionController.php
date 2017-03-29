<?php namespace Scalex\Zero\Http\Controllers\Api\Attendance;

use Illuminate\Http\Request;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\CourseSession;
use Scalex\Zero\Models\Student;
use Scalex\Zero\Repositories\AttendanceRepository;

class SessionController extends Controller
{

    /**
     * Add auth middleware for all routes.
     */
    public function __construct()
    {
        $this->middleware('auth:api,web');
    }

    public function index(CourseSession $session, Request $request)
    {
        $this->authorize('view-attendance', $session);

        return $session->attendances;
    }

    public function show(CourseSession $session, Student $student, AttendanceRepository $repository, Request $request)
    {
        $this->authorize('view-attendance', $session);
        return $repository->getAttendanceFor($student, $session);
    }


    public function store(Request $request, CourseSession $session, AttendanceRepository $repository)
    {
        $this->authorize('create-attendance', $session);
        $studentIds = $request->attendance;
        $allStudents = [];
        $session->students->each(function ($student) use (&$allStudents) {
            $allStudents[$student->id] = true;
        });
        $studentIds = array_replace($allStudents, $studentIds);
        $date = \Carbon\Carbon::parse($request->date);
        $repository->takeAttendance($studentIds, $session, $date);
        return $this->accepted();
    }

    public function destroy()
    {
        abort('401');

    }







}
