<?php namespace Scalex\Zero\Events\User;

use Illuminate\Queue\SerializesModels;
use Scalex\Zero\User;

class UserEmailUpdated
{
    use SerializesModels;
    /**
     * @var \Scalex\Zero\User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user) {
        $this->user = $user;
    }
}
