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

    public function index(Request $request, CourseSession $session)
    {
        $this->authorize('view-attendance', $session);

        return $session->attendances;
    }

    public function show(Request $request, CourseSession $session, Student $student, AttendanceRepository $repository)
    {
        $this->authorize('view-attendance', $session);
        return $repository->getAttendanceFor($student, $session);
    }

    public function store(Request $request, CourseSession $session, AttendanceRepository $repository)
    {
        $this->authorize('take-attendance', $session);
        $studentIds = collect($request->input['students']);
        $date = $request->input('date');
        $repository->takeAttendance($studentIds, $session, $date);
        return $this->accepted();
    }







}
