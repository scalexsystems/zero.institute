<?php

namespace Scalex\Zero\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailVerificationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    /**
     * @var
     */
    public $name;
    /**
     * @var
     */
    public $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $url)
    {
        $this->name = $name;
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Verify your email address')
                    ->view('emails.user.verify');
    }
}
