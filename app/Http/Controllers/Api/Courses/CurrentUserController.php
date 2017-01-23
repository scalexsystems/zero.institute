<?php

namespace Scalex\Zero\Http\Controllers\Api\Courses;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\Teacher;
use Scalex\Zero\Models\Course;
use Scalex\Zero\Models\Student;

class CurrentUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api,web');
    }

    /**
     * List of current courses related to user.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $request->query->add(['with' => 'session']);

        if ($user->person instanceof Teacher or $user->person instanceof Student) {
            $user->person->load('sessions', 'sessions.course');
            $courses = $user->person->sessions->map(function ($session) {
                $session->course->session = $session;

                return $session->course;
            });
            $courses->load(array_merge(['photo', 'prerequisites']));

            return $courses;
        }

        abort(401, 'You are not allowed to join courses.');
    }

    public function show(Request $request, $courseId)
    {
        abort(401, 'You are not allowed to join courses.');
    }
}
