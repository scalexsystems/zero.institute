<?php namespace Scalex\Zero\Listeners;

use Illuminate\Mail\Message;
use Mail;
use Scalex\Zero\Events\User\AccountIntentSubmitted;
use Scalex\Zero\Events\User\UserEmailUpdated;
use Scalex\Zero\Notifications\VerificationEmailSent;

class UserEventSubscriber
{
    public function onEmailUpdate(UserEmailUpdated $event)
    {
        $token = $event->getUser()->other_verification_token;
        $email = $event->getUser()->email;
        $name = $event->getUser()->email;
        Mail::queue('emails.user.verify', [
            'name' => $event->getUser()->name,
            'token' => $token,
            'url' => url('/account/update/email/verify/'.$token),
        ], function (Message $message) use ($name, $email) {
            $message->to($email, $name);
            $message->subject('Verify Your Email');
        });
        $event->getUser()->notify(new VerificationEmailSent($email));
    }

    public function onNewAccountRequest(AccountIntentSubmitted $event)
    {
        cache()->forget(schoolScopeCacheKey('stats.accounts'));
        cache()->forget(schoolScopeCacheKey('stats.incomplete'));
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(UserEmailUpdated::class, self::class.'@onEmailUpdate');
        $events->listen(AccountIntentSubmitted::class, self::class.'@onNewAccountRequest');
    }
}
