<?php

namespace Scalex\Zero\Http\Controllers\Auth;

use Illuminate\Http\Request;

use Scalex\Zero\Http\Requests;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\User;

class VerificationController extends Controller
{
    public function updateEmail($token)
    {
        $user = repository(User::class)->findBy(
            User::getExtendedQueryKey('other_verification_token'),
            $token
        );

        $user->other_verification_token = null;
        $user->email = $user->other_email;
        $user->other_email = null;

        repository(User::class)->update($user, []);

        // Redirect to login screen with message.

        return redirect('/login')->with('message', 'Your email address is verified.');
    }

    public function verifyEmail($token)
    {
        $user = repository(User::class)->findBy('verification_token', $token);

        $user->verification_token = null;

        repository(User::class)->update($user, []);

        // Redirect to login screen with message.

        return redirect('/login');
    }
}
