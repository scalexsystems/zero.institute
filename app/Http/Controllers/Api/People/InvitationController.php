<?php namespace Scalex\Zero\Http\Controllers\Api\People;

use Illuminate\Http\Request;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Jobs\SendInvitations;

class InvitationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api,web');
    }

    public function invite(Request $request)
    {
        $this->validate($request, [
            'emails.*' => 'required|email',
            'type' => 'required|in:student,teacher,employee',
        ]);

        $this->authorize('send-invitation', morph_model($request->input('type')));

        dispatch(new SendInvitations($request->input('type'), $request->input('emails'), $request->user()));

        return $this->accepted();
    }
}
