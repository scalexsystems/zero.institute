<?php namespace Scalex\Zero\Http\Controllers\Api\Students;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Scalex\Zero\Criteria\OrderBy;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Http\Requests;
use Scalex\Zero\Mail\InvitationMail;
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

    public function invite(Request $request) {
        $this->validate($request, [
            'students.*' => 'required | email',
        ]);
        $this->authorize('invite',  Student::class);
        Mail::to($request->students)
            ->queue(new InvitationMail());
    }
}
