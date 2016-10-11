<?php namespace Scalex\Zero\Http\Controllers\Api;

use Illuminate\Http\Request;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Http\Requests;
use Scalex\Zero\Models\Student;

class StudentController extends Controller
{
    public function index(Request $request) {
        $students = repository(Student::class)->with('profilePhoto');

        if ($request->has('q')) {
            $students->search($request->input('q'));
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
