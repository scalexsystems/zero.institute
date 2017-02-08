<?php

namespace Scalex\Zero\Http\Controllers\Api\Courses;

use Illuminate\Http\Request;
use Scalex\Zero\Events\CourseCreated;
use Scalex\Zero\Events\CourseDeleted;
use Scalex\Zero\Events\CourseUpdated;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\Course;
use Scalex\Zero\Models\Course\Session;
use Scalex\Zero\Criteria\OrderBy;
use Carbon\Carbon;
use Scalex\Zero\Repositories\CourseRepository;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api,web');
    }

    public function index(Request $request, CourseRepository $repository)
    {
        $this->authorize('index', Course::class);

        $relations = ['photo', 'sessions', 'instructors', 'prerequisites'];

        $repository->with($relations);

        if ($request->has('q')) {
            $repository->search($request->input('q'));
        } else {
            $repository->pushCriteria(new OrderBy('name'));
        }

        return transform($repository->paginate(), $relations, null, true);
    }

    public function show(Request $request, Course $course)
    {
        $this->authorize('view', $course);

        return transform($course, [/* TODO: Add required relations here! */], null, true);
    }

    public function store(Request $request, CourseRepository $repository)
    {
        $this->authorize('create', Course::class);

        $course = $repository->createForSchool($request->user()->school, $request->all());

        if ($request->has('prerequisites')) {
            $repository->addPrerequisites($course, (array)$request->input('prerequisites'));
        }

        if ($request->has('instructors')) {
            $repository->addInstructors($course, (array)$request->input('instructors'));
        }

        broadcast(new CourseCreated($course));

        return $course;
    }

    public function update(Request $request, Course $course, CourseRepository $repository)
    {
        $this->authorize('update', $course);

        $repository->update($course, $request->all());

        broadcast(new CourseUpdated($course));

        return $course;
    }

    public function destroy(Request $request, Course $course)
    {
        $this->authorize('delete', $course);

        repository($course)->delete($course);

        broadcast(new CourseDeleted($course));

        return $this->accepted();
    }
}
