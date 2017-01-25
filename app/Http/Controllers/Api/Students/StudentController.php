<?php namespace Scalex\Zero\Http\Controllers\Api\Students;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Scalex\Zero\Criteria\OrderBy;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Http\Requests;
use Scalex\Zero\Models\Student;
use Scalex\Zero\Jobs\InvitationMailer;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api,web');
    }

    public function index(Request $request)
    {
        $students = repository(Student::class)->with('profilePhoto');

        if ($request->has('q')) {
            $students->search($request->input('q'));
        } else {
            $students->pushCriteria(new OrderBy(['first_name', 'last_name']));
        }

        return $students->simplePaginate();
    }

    public function show(Request $request, $student)
    {
        $student = repository(Student::class)->findBy('uid', $student);
        $this->authorize($student);

        $request->query->set('with', ['profilePhoto', 'address', 'father', 'mother']);

        return $student;
    }

    public function update(Request $request, Student $student) {
        $this->authorize($student);
        $data = $request->all();
        $data['uid'] = $student->uid;
        repository(Student::class)->update($student, $data);
        $this->accepted();
    }

    public function invite(Request $request)
    {
        $this->authorize('invite', Student::class);
        $this->validate($request, [
            'students.*' => 'required | email',
        ]);

        dispatch(new InvitationMailer('student', $request->students, $request->user()->school_id, $request->user()));
    }
}
