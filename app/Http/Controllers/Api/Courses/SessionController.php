<?php

namespace Scalex\Zero\Http\Controllers\Api\Courses;

use Illuminate\Http\Request;
use Scalex\Zero\Events\CourseSession\Created;
use Scalex\Zero\Events\CourseSession\Deleted;
use Scalex\Zero\Events\CourseSession\Updated;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\Course;
use Scalex\Zero\Models\CourseSession;

class SessionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api,web');
    }

    public function index(Course $course)
    {
        $this->authorize('view-sessions', $course);

        return $course->sessions()->paginate();
    }

    public function show(Course $course, CourseSession $session)
    {
        $this->authorize('view-sessions', $course);

        return $session;
    }

    public function store(Course $course, Request $request)
    {
        abort(404);
    }

    public function update($course, CourseSession $session, Request $request)
    {
        $this->authorize('update', $session);

        $session = repository(CourseSession::class)->update($session, $request->all());

        broadcast(new Updated($session));

        return $session;
    }

    public function destroy($course, CourseSession $session)
    {
        $this->authorize('delete', $session);

        repository(CourseSession::class)->delete($session);

        broadcast(new Deleted($session));

        return $this->accepted();
    }
}
