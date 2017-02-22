<?php

namespace Scalex\Zero\Http\Controllers\Api\Courses;

use Illuminate\Http\Request;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\Course;
use Scalex\Zero\Models\CourseSession;
use Scalex\Zero\Models\Employee;
use Scalex\Zero\Models\Student;
use Scalex\Zero\Models\Teacher;
use Scalex\Zero\Repositories\CourseRepository;

class CurrentUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api,web');
    }

    public function index(Request $request, CourseRepository $repository)
    {
        $person = $this->getPerson($request);

        if ($person instanceof Employee) {
            return collect([]);
        }

        if ($person instanceof Teacher) {
            return CourseSession::where('instructor_id', $person->getKey())
                                ->where('session_id', $request->user()->school->session_id)
                                ->get();
        }

        if ($person instanceof Student) {
            $ids = $person->sessions->pluck('id')->toArray();

            return CourseSession::where('session_id', $request->user()->school->session_id)->find($ids);
        }

        abort(404);
    }


    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Scalex\Zero\Models\Student|\Scalex\Zero\Models\Teacher|\Scalex\Zero\Models\Employee
     */
    protected function getPerson(Request $request)
    {
        return $request->user()->person;
    }
}
