<?php

namespace Scalex\Zero\Http\Controllers\Api\Courses;

use Illuminate\Http\Request;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\Course;
use Scalex\Zero\Models\Course\Session;
use Scalex\Zero\Models\Student;

/* Uses /me Scope. */
class EnrollmentController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api,web');
    }

    /**
     * Get list of enrolled students in the course.
     */
    public function index(Request $request, Course $course)
    {

        $request->query->set('with', ['user']);
        $session = repository(Course::class)->findActiveSessions($course, $request->user())->first();

        if (! ($session instanceof Session)) {
            abort(404, 'No active session found for the course - '.$course->name);
        }

        $paginator = $session->students()->paginate();

        $paginator->getCollection()->load(['user', 'profilePhoto']);

        return $paginator;
    }

    
    /**
     * Enroll students to Current session.
     *  - Current session is **First** active session of the $course isntructed by $user (Auth user.).
     */
    public function store(Request $request, Course $course)
    {
        $this->validate($request, ['session_id' => 'required', 'students' => 'required|array|min:1']);
        $session = repository(Session::class)->find($request->input('session_id'));

        $this->authorize('enroll', $session);

        $studentIds = repository(Student::class)
            ->filterBySchool((array)$request->input('students'), $request->user()->school)->toArray();

        if (count($studentIds)) {
            repository(Session::class)->enroll($session, $studentIds);
        }

        return $this->accepted();
    }
}
