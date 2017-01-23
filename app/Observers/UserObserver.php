<?php namespace Scalex\Zero\Observers;

use Mail;
use Scalex\Zero\Mail\EmailVerificationMail;
use Scalex\Zero\User;

class UserObserver
{
    public function created(User $user)
    {
        Mail::to($user)
            ->queue(
                new EmailVerificationMail(
                    $user->name,
                    url('/account/email/verify/'.$user->verification_token)
                )
            );
    }
}
