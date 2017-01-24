<?php

namespace Scalex\Zero\Http\Controllers\Api\Courses;

use Illuminate\Http\Request;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\Course;
use Scalex\Zero\Models\Course\Session;
use Scalex\Zero\Criteria\OrderBy;
use Carbon\Carbon;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api,web');
    }

    /*
     * Get all courses.
     * GET /courses
     * Requires: auth
     */
    public function index(Request $request)
    {
        $this->authorize('index', Course::class);

        $request->query->set('with', ['photo', 'sessions', 'instructors', 'prerequisites', 'active_sessions', 'future_sessions']);

        $courses = repository(Course::class)->with(['photo', 'sessions', 'instructors', 'prerequisites']);

        if ($request->has('q')) {
            $courses->search($request->input('q'));
        } else {
            $courses->pushCriteria(new OrderBy('name'));
        }

        return $courses->paginate();
    }

    /*
     * Get a course.
     * GET /courses/{course}
     * Required: auth
     */
    public function show(Request $request, Course $course)
    {
        $this->authorize($course);

        return $course;
    }

    /*
     * Create a course.
     * POST /courses
     * Requires: auth
     */
    public function store(Request $request)
    {
        $this->authorize('store', Course::class);

        $course = repository(Course::class)->create(
            ['school_id' => current_user()->school_id] + $request->all()
        );

        $teacher = $course->instructors->first();

        if ($teacher) {
            repository(Session::class)->create([
                'course_id' => $course->getKey(),
                'instructor_id' => $teacher->getKey(),
                'started_on' => Carbon::now(),
                'ended_on' => Carbon::now()->addMonth(4),
            ]);
        }

        return $course;
    }

    /*
     * Update a course.
     * PUT /courses/{course}
     * Requires: auth
     */
    public function update(Request $request, Course $course)
    {
        $this->authorize('update', $course);

        repository($course)->update($course, $request->all());

        $course->fresh('instructors');

        $teacher = $course->instructors->first();
        $session = $course->sessions->filter(function ($session) {
            return $session->ended_on->isFuture();
        })->first();

        if ($teacher and $session) {
            repository(Session::class)->update($session, [ 'instructor_id' => $teacher->getKey() ]);
        } elseif ($teacher) {
            repository(Session::class)->create([
                'course_id' => $course->getKey(),
                'instructor_id' => $teacher->getKey(),
                'started_on' => Carbon::now(),
                'ended_on' => Carbon::now()->addMonth(4),
            ]);
        }

        return $course;
    }

    /*
     * Delete a course.
     * DELETE /courses/{course}
     * Requried: auth
     */
    public function destroy(Request $request, Course $course)
    {
        $this->authorize('delete', $course);

        repository($course)->delete($course);

        return $this->accepted();
    }
}
