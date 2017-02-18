<?php namespace Scalex\Zero\Events\User;

use Scalex\Zero\Events\Event;
use Scalex\Zero\User;

abstract class AbstractUserEvent extends Event
{
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function broadcastOn()
    {
        return $this->user->getChannel();
    }
}
