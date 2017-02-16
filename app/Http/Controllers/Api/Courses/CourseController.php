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

        $repository->with($this->getDefaultRelations());

        if ($request->has('q')) {
            $repository->search($request->input('q'));
        } else {
            $repository->pushCriteria(new OrderBy('name'));
        }

        $courses = $repository->paginate();

        return $this->transform($courses);
    }

    public function show(Request $request, Course $course)
    {
        $this->authorize('view', $course);

        return $this->transform($course);
    }

    public function store(Request $request, CourseRepository $repository)
    {
        $this->authorize('create', Course::class);

        $course = $repository->createForSchool($request->user()->school, $request->all());

        if ($request->has('courses')) {
            $repository->addPrerequisites($course, (array)$request->input('courses'));
        }

        broadcast(new CourseCreated($course));

        return $this->transform($course);
    }

    public function update(Request $request, Course $course, CourseRepository $repository)
    {
        $this->authorize('update', $course);

        $repository->update($course, $request->all());

        if ($request->has('courses')) {
            $repository->addPrerequisites($course, (array)$request->input('courses'));
        }

        broadcast(new CourseUpdated($course));

        return $this->transform($course);
    }

    public function destroy(Request $request, Course $course)
    {
        abort(401);
    }

    /**
     * @return array
     */
    protected function getDefaultRelations(): array
    {
        return ['photo', 'prerequisites', 'sessions', 'sessions.instructor', 'instructors'];
    }

    /**
     * @param $courses
     *
     * @return array
     */
    protected function transform($courses): array
    {
        return transform($courses, $this->getDefaultRelations(), null, true);
    }
}
