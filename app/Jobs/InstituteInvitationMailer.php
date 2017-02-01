<?php

namespace Scalex\Zero\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Scalex\Zero\Mail\InstituteInvitationMail;
use Scalex\Zero\User;

class InstituteInvitationMailer implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * List of user emails.
     *
     * @var string[]
     */
    protected $email;


    /**
     * Name of the institute.
     *
     * @var User
     */
    protected $instituteName;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $instituteName, string $email)
    {
        $this->instituteName = $instituteName;
        $this->email = $email;
    }

    /**
     * Send invitation emails.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)->send(new InstituteInvitationMail($this->instituteName, $this->email));
    }
}
