<?php

namespace Scalex\Zero\Http\Controllers\Api\Courses;

use Illuminate\Http\Request;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\Course\Session;

class SessionController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api,web');
    }

    /**
     * List all sessions.
     */
    public function index(Course $course) {
        $this->authorize('index-sessions', $course);

        return $course->sessions;
    }
}
