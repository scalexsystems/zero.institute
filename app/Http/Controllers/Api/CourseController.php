<?php

namespace Scalex\Zero\Http\Controllers\Api;

use Illuminate\Http\Request;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\Course;
use Scalex\Zero\Criteria\OrderBy;

class CourseController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api,web');
    }

    /*
     * Get all courses.
     * GET /courses
     * Requires: auth
     */
    public function index(Request $request) {
        $this->authorize('index', Course::class);

        $courses = repository(Course::class)->with('photo');

        if ($request->has('q')) {
            $courses->search($request->input('q'));
        } else {
            $courses->pushCriteria(new OrderBy('name'));
        }

        return $courses->simplePaginate();
    }

    /*
     * Get a course.
     * GET /courses/{course}
     * Required: auth
     */
    public function show(Request $request, Course $course) {
        $this->authorize($course);

        return $course;
    }

    /*
     * Create a course.
     * POST /courses
     * Requires: auth
     */
    public function store(Request $request) {
        $this->authorize('store', Course::class);

        $course = repository(Course::class)->create(
            ['school_id' => current_user()->school_id] + $request->all()
        );

        return $course;
    }

    /*
     * Update a course.
     * PUT /courses/{course}
     * Requires: auth
     */
    public function update(Request $request, Course $course) {
        $this->authorize('update', $course);

        repository($course)->update($course, $request->all());

        return $course;
    }

    /*
     * Delete a course.
     * DELETE /courses/{course}
     * Requried: auth
     */
    public function destroy(Request $request, Course $course) {
        $this->authorize('delete', $course);

        repository($course)->delete($course);

        return $this->accepted();
    }
}
