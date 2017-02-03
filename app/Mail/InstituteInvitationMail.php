<?php
namespace Scalex\Zero\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Scalex\Zero\User;

class InstituteInvitationMail extends Mailable
{
    /**
     * Sending invitation to the user.
     *
     * @var User
     */
    protected $user;

    /**
     * Name of Institute.
     *
     * @var User
     */
    protected $instituteName;
    protected $email;

    public function __construct(string $instituteName, string $email)
    {
        $this->email = $email;
        $this->instituteName = $instituteName;
    }

    public function build()
    {
        return $this->subject($this->email)
            ->view('emails.invitation.html')
            ->with([
                'name' => $this->instituteName,
                'email' => $this->email,
            ]);
    }
}
