<?php namespace Scalex\Zero\Http\Controllers\Api\People;

use Illuminate\Http\Request;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\Student;

class InvitationController extends Controller
{
    public function invite(Request $request)
    {
        $this->authorize('invite', Student::class);

        $this->validate($request, ['students.*' => 'required | email']);

        // TODO: Fix
        dispatch(new InvitationMailer('student', $request->students, $request->user()->school_id, $request->user()));
    }
}
