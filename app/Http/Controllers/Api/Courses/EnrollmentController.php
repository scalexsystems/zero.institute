<?php

namespace Scalex\Zero\Http\Controllers\Api\Courses;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Scalex\Zero\Events\CourseSession\EnrolledStudents;
use Scalex\Zero\Events\CourseSession\ExpelledStudents;
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

        return $session->students->load('user', 'photo');
    }

    public function store(Course $course, CourseSession $session, Request $request)
    {
        $this->authorize('enroll', $session);

        $this->validate($request, [
            'student' => [
                'bail',
                'required',
                Rule::exists('students', 'id')->where('school_id', $course->school_id),
            ],
        ]);

        $students = repository(CourseSession::class)->enroll(
            $session,
            Student::findMany((array)$request->input('student'))
        );

        broadcast(new EnrolledStudents($session, $students));

        return $students->modelKeys();
    }

    public function destroy($course, CourseSession $session, Request $request)
    {
        $this->authorize('expel', $session);

        $this->validate($request, [
            'student' => [
                'bail',
                'required',
                Rule::exists('students', 'id')->where('school_id', $course->school_id),
            ],
        ]);

        $students = repository(CourseSession::class)->expel(
            $session,
            Student::findMany((array)$request->input('student'))
        );

        broadcast(new ExpelledStudents($session, $students));

        return $this->accepted();
    }
}
