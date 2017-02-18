<?php

namespace Scalex\Zero\Http\Controllers\Api\Courses;

use Illuminate\Http\Request;
use Scalex\Zero\Events\CourseSession\EnrolledStudents;
use Scalex\Zero\Events\Course\Session\StudentsExpelled;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\Course;
use Scalex\Zero\Models\CourseSession;
use Scalex\Zero\Models\Student;

class EnrollmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api,web');
    }

    public function index($course, CourseSession $session)
    {
        $this->authorize('view-enrolled-students', $session);

        return $session->students()->getQuery()
                       ->with('photo', 'user')
                       ->get();
    }

    public function store($course, CourseSession $session, Request $request)
    {
        $this->authorize('enroll', $session);

        $this->validate($request, ['students' => 'required|array|min:1']);

        $students = Student::whereSchoolId($course->school_id)->findMany($request->input('students'));

        repository(CourseSession::class)->enroll($session, $students);

        broadcast(new EnrolledStudents($session, $students));

        return $this->accepted();
    }

    public function destroy($course, CourseSession $session, Request $request)
    {
        $this->authorize('expel', $session);

        $this->validate($request, ['students' => 'required|array|min:1']);

        $students = Student::whereSchoolId($course->school_id)->findMany($request->input('students'));

        repository(CourseSession::class)->expel($session, $students);

        broadcast(new StudentsExpelled($session, $students));

        return $this->accepted();
    }
}
