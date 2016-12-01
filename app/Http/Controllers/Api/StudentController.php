<?php namespace Scalex\Zero\Http\Controllers\Api;

use Illuminate\Http\Request;
use Scalex\Zero\Criteria\OrderBy;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Http\Requests;
use Scalex\Zero\Models\Student;

class StudentController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api,web');
    }

    public function index(Request $request) {
        $students = repository(Student::class)->with('profilePhoto');

        if ($request->has('q')) {
            $students->search($request->input('q'));
        } else {
            $students->pushCriteria(new OrderBy(['first_name', 'last_name']));
        }

        return $students->simplePaginate();
    }

    public function show(Request $request, $student) {
        $student = repository(Student::class)->findBy('uid', $student);
        $this->authorize($student);

        $request->query->set('with', ['profilePhoto', 'address', 'father', 'mother']);

        return $student;
    }
}
