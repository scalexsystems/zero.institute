<?php

namespace Scalex\Zero\Listeners\Invitation;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Message;
use Mail;
use Scalex\Zero\Events\School\InvitationRequest;

class ReportNewInvitationRequest implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  InvitationRequest $event
     *
     * @return void
     */
    public function handle(InvitationRequest $event) {
        $name = $event->name;
        Mail::send(
            ['raw' => "New invite request from {$event->email} for {$event->name}."],
            [],
            function (Message $message) use ($name) {
                $message->to('invite@scalex.xyz');
                $message->from('no-reply@scalex.xyz', 'Scalex System');
                $message->subject('Invite Request - '.$name);
            }
        );
    }
}
