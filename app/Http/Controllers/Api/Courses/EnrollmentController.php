<?php

namespace Scalex\Zero\Http\Controllers\Api\Courses;

use Illuminate\Http\Request;
use Scalex\Zero\Events\Course\Session\StudentsEnrolled;
use Scalex\Zero\Events\Course\Session\StudentsExpelled;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\Course;
use Scalex\Zero\Models\Course\Session;
use Scalex\Zero\Models\Student;

/* Uses /me Scope. */
class EnrollmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api,web');
    }

    public function index($course, Session $session)
    {
        $this->authorize('view-enrolled-students', $session);

        return $session->students()->getQuery()
                                   ->with('photo', 'user')
                                   ->paginate();
    }

    public function store($course, Session $session, Request $request)
    {
        $this->validate($request, ['students' => 'required|array|min:1']);

        $students = Student::whereSchoolId($course->school_id)->findMany($request->input('students'));

        repository(Session::class)->enroll($session, $students);

        broadcast(new StudentsEnrolled($session, $students));

        return $this->accepted();
    }

    public function destroy($course, Session $session, Request $request)
    {
        $this->validate($request, ['students' => 'required|array|min:1']);

        $students = Student::whereSchoolId($course->school_id)->findMany($request->input('students'));

        repository(Session::class)->expel($session, $students);

        broadcast(new StudentsExpelled($session, $students));

        return $this->accepted();
    }
}
