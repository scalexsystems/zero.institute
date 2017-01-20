<?php namespace Scalex\Zero\Http\Controllers\Api\Teachers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Scalex\Zero\Criteria\OrderBy;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Mail\InvitationMail;
use Scalex\Zero\Models\Teacher;
use Scalex\Zero\Jobs\InvitationMailer;

class TeacherController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api,web');
    }

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

    public function invite(Request $request){
        $this->authorize('invite', Teacher::class);
        $this->validate($request, [
            'teachers.*' => 'required|email'
        ]);

        dispatch(new InvitationMailer('teacher', $request->teachers, $request->user()->school_id, $request->user()));
    }
}
