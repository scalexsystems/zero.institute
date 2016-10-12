<?php namespace Scalex\Zero\Http\Controllers\Api;

use Illuminate\Http\Request;
use Scalex\Zero\Criteria\OrderBy;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\Teacher;

class TeacherController extends Controller
{
    public function index(Request $request) {
        $teachers = repository(Teacher::class)->with('profilePhoto');

        if ($request->has('q')) {
            $teachers->search($request->input('q'));
        } else {
            $teachers->pushCriteria(new OrderBy(['first_name', 'last_name']));
        }

        return $teachers->simplePaginate();
    }

    public function show(Request $request, $teacher) {
        $teacher = repository(Teacher::class)->findBy('uid', $teacher);
        $this->authorize($teacher);

        $request->query->set('with', ['profilePhoto', 'address']);

        return $teacher;
    }
}
