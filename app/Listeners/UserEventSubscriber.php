<?php namespace Scalex\Zero\Listeners;

use Illuminate\Mail\Message;
use Mail;
use Scalex\Zero\Events\User\AccountIntentSubmitted;
use Scalex\Zero\Events\User\UserEmailUpdated;

class UserEventSubscriber
{
    public function onEmailUpdate(UserEmailUpdated $event) {
        $token = $event->user->other_verification_token;
        $email = $event->user->email;
        $name = $event->user->email;
        Mail::queue('emails.user.verify', [
            'name' => $event->user->name,
            'token' => $token,
            'url' => url('/account/update/email/verify/'.$token),
        ], function (Message $message) use ($name, $email) {
            $message->to($email, $name);
            $message->subject('Verify Your Email');
        });
    }

    public function onNewAccountRequest(AccountIntentSubmitted $event) {
        cache()->forget(schoolify('stats.accounts'));
        cache()->forget(schoolify('stats.incomplete'));
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events) {
        $events->listen(UserEmailUpdated::class, self::class.'@onEmailUpdate');
        $events->listen(AccountIntentSubmitted::class, self::class.'@onNewAccountRequest');
    }
}
