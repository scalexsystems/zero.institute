<?php

namespace Scalex\Zero\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;
use Scalex\Zero\Models\Teacher;
use Scalex\Zero\User;
use Scalex\Zero\Mail\InvitationMail;
use Scalex\Zero\Models\Role;
use Carbon\Carbon;

class InvitationMailer implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Type of user account.
     *
     * @var string
     */
    protected $type;

    /**
     * List of user emails.
     *
     * @var string[]
     */
    protected $emails;

    /**
     * ID for the school in database.
     *
     * @var int
     */
    protected $schoolId;

    /**
     * User sending out invitations.
     *
     * @var User
     */
    protected $admin;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $type, array $emails, int $schoolId, User $user)
    {
        $this->type = $type;
        $this->emails = $emails;
        $this->schoolId = $schoolId;
        $this->admin = $user;
    }

    /**
     * Send invitation emails.
     *
     * @return void
     */
    public function handle()
    {
        collect($this->emails)->chunk(100)->each(function ($emails) {
            $duplicates = User::whereIn('email', $emails)->get()->pluck('email');

            $emails = $emails->diff($duplicates);

            $users = $this->createUsers($emails);

            $users->each(function ($user) {
                Mail::to($user->email)->send(new InvitationMail($user, $this->admin));
            });
        });
    }

    public function createUsers($emails)
    {
        $timestamp = Carbon::now();

        User::insert($emails->map(function ($email) use ($timestamp) {
            return [
                'name' => $email,
                'email' => $email,
                'school_id' => $this->schoolId,
                'password' => bcrypt(str_random(32)),
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ];
        })->toArray());

        Teacher::insert($emails->map(function ($email) {
            return [
                'uid' => $email,
                'school_id' => $this->schoolId
            ];
        })->toArray());

        $users = User::whereIn('email', $emails->toArray())->get();
        $teachers = Teacher::whereIn('uid', $emails->toArray())->get()->keyBy('uid');

        $users->load('school');

        $users->each(function ($user) use ($teachers) {
            $user->person()->save($teachers->get($user->email));
        });

        return $users;
    }
}
