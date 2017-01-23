<?php namespace Scalex\Zero\Policies;

use Scalex\Zero\Models\Message;
use Scalex\Zero\User;

class MessagePolicy extends AbstractPolicy
{
    public function read(User $user, Message $message)
    {
        return (int)$message->receiver_id === (int)$user->getKey() and $message->receiver_type === $user->getMorphClass();
    }
}
