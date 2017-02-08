<?php

namespace Scalex\Zero\Http\Controllers\Api\Courses;

use Illuminate\Http\Request;
use Scalex\Zero\Events\Course\Session\SessionCreated;
use Scalex\Zero\Events\Course\Session\SessionDeleted;
use Scalex\Zero\Events\Course\Session\SessionUpdated;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\Course;
use Scalex\Zero\Models\Course\Session;

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

    public function show(Course $course, Session $session)
    {
        $this->authorize('view-sessions', $course);

        return $session;
    }

    public function store(Course $course, Request $request)
    {
        $this->authorize('create-session', $course);

        $session = repository(Session::class)->createForCourse($course, $request->all());

        broadcast(new SessionCreated($session));

        return $session;
    }

    public function update($course, Session $session, Request $request)
    {
        $this->authorize('update', $session);

        $session = repository(Session::class)->update($session, $request->all());

        broadcast(new SessionUpdated($session));

        return $session;
    }

    public function destroy($course, Session $session)
    {
        $this->authorize('delete', $session);

        repository(Session::class)->delete($session);

        broadcast(new SessionDeleted($session));

        return $this->accepted();
    }
}
