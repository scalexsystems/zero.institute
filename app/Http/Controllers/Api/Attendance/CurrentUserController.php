<?php
/**
 * Created by PhpStorm.
 * User: dpc
 * Date: 3/3/17
 * Time: 5:56 PM
 */

namespace Scalex\Zero\Http\Controllers\Api\Attendance;

use Request;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\CourseSession;
use Scalex\Zero\Models\Semester;
use Scalex\Zero\Models\Student;
use Scalex\Zero\Models\Teacher;

class CurrentUserController extends Controller

{
    public function __construct()
    {
        $this->middleware('auth:api,web');
    }

    public function index(Request $request, Semester $semester, Student $student)
    {
        $this->authorize('view-sessions', $student);

        $user = request()->user();

        if ($user->person instanceof Teacher) {
            return CourseSession::with(['course' => function ($query) use ($semester) {
                return $query->where('semester_id', $semester->id);
            }])
                ->where('instructor_id', $user->id)
                ->get();

        }

        if ($user->person instanceof Student) {
            return $student->sessions;
        }

        abort(404);

    }


}