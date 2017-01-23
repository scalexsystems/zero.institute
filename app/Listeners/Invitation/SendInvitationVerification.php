<?php

namespace Scalex\Zero\Listeners\Invitation;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Message;
use Mail;
use Scalex\Zero\Events\School\InvitationRequest;

class SendInvitationVerification implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  InvitationRequest $event
     *
     * @return void
     */
    public function handle(InvitationRequest $event)
    {
        $name = $event->name;
        $email = $event->email;
        Mail::send(
            ['view' => 'emails.invitation.html', 'text' => 'emails.invitation.text'],
            compact('name'),
            function (Message $message) use ($email) {
                $message->to($email);
                $message->from('suwardhan@scalex.xyz', 'Suwardhan Ahirrao');
                $message->replyTo('hello@scalex.xyz', 'Scalex Systems');
                $message->subject('Scalex Zero Invite - Verification');
            }
        );
    }
}
