<?php namespace Scalex\Zero\Http\Controllers\Api\Courses;

use Illuminate\Http\Request;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\Course;
use Scalex\Zero\Repositories\CourseRepository;

class InstructorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api,web');
    }

    public function index(Course $course)
    {
        return $course->instructors()->getQuery()->with('photo', 'user')->paginate();
    }

    public function store(Course $course, Request $request)
    {
        $this->validate($request, ['instructors' => 'required|array|min:1']);

        repository(Course::class)->addInstructors($course, $request->input('instructors'));

        return $this->accepted();
    }

    public function destroy(Request $request, Course $course, CourseRepository $repository)
    {
        $this->validate($request, ['instructors' => 'required|array|min:1']);

        repository(Course::class)->removeInstructors($course, $request->input('instructors'));

        return $this->accepted();
    }
}
