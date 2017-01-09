<?php
/**
 * Created by PhpStorm.
 * User: dpc
 * Date: 9/1/17
 * Time: 3:16 PM
 */

namespace Scalex\Zero\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvitationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function build() {
        return $this->subject('Welcome')
            ->view('emails.user.invite');
    }


}