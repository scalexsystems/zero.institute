<?php

namespace Scalex\Zero\Http\Controllers;

use Cache;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Scalex\Zero\Events\School\InvitationRequest;

class HomeController extends Controller
{
    /**
     * Show the app homepage.
     *
     * @route GET /
     * @auth yes
     */
    public function app()
    {
        return view('app.home');
    }

    /**
     * Show the zero homepage.
     * @route GET /
     * @auth no
     */
    public function home()
    {
        // If authenticated then serve app.
        if (auth()->check()) {
            return $this->app();
        }

        $count = 0;

        return view('web.home', compact('count'));
    }

    /**
     * Show social media share intent.
     * @route GET /share
     */
    public function share()
    {
        return view('web.share');
    }

    /**
     * Accept invite request.
     * @route GET|POST /request
     */
    public function request(Request $request)
    {
        $this->validate(
            $request,
            [
                'email' => 'required|email',
                'name' => 'required',
            ]
        );

        $email = $request->input('email');
        $name = $request->input('name');
        $created_at = Carbon::now();

        if (
            DB::connection('sqlite')
                ->table('requests')
                ->where('email', $email)
                ->count() === 0
        ) {
            DB::connection('sqlite')
                ->table('requests')
                ->insert(compact('email', 'name', 'created_at'));
            Cache::forget('requests.count');

            event(new InvitationRequest($name, $email));
        }

        return view('web.accepted-invitation-request');
    }

    public function privacy()
    {
        return view('web.privacy');
    }
}
