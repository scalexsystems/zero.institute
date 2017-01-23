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
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Scalex\Zero\User;

class InvitationMail extends Mailable
{
    /**
     * Sending invitation to the user.
     *
     * @var User
     */
    protected $user;

    /**
     * Invitation sender.
     *
     * @var User
     */
    protected $admin;

    public function __construct(User $user, User $admin)
    {
        $this->user = $user;
        $this->admin = $admin;
    }

    public function build()
    {
        $tokens = app('auth.password')->getRepository();

        $token = $tokens->create($this->user);

        return $this->subject('')
                ->view('emails.user.invite')
                ->with([
                    'type' => $this->user->person_type,
                    'school' => $this->user->school->name,
                    'url' => url('password/reset', $token),
                    'name' => $this->admin->name,
                ]);
    }
}
