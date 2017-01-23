<?php namespace Scalex\Zero\Events\User;

use Illuminate\Queue\SerializesModels;
use Scalex\Zero\User;

class UserEmailUpdated
{
    use SerializesModels;
    /**
     * @var \Scalex\Zero\User
     */
    protected $user;

    /**
     * @return \Scalex\Zero\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
