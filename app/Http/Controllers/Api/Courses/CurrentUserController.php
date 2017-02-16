<?php

namespace Scalex\Zero\Http\Controllers\Api\Courses;

use Illuminate\Http\Request;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\Course;
use Scalex\Zero\Models\Employee;
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

        return $person->sessions;
    }

    public function show(Request $request, Course $course, CourseRepository $repository)
    {
        $session = $repository->findActiveSessions($course, $request->user())->first();

        if ($session) {
            return $session;
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
