<?php namespace Scalex\Zero\Policies;

use Scalex\Zero\Models\Group;
use Scalex\Zero\Models\Message;
use Scalex\Zero\User;

class MessagePolicy extends AbstractPolicy
{
    /**
     * Set read status.
     *
     * @param \Scalex\Zero\User $user
     * @param \Scalex\Zero\Models\Message $message
     *
     * @return bool
     */
    public function read(User $user, Message $message)
    {
        if ($message->receiver instanceof Group) {
            return $message->receiver->isMember($user)
                   and (
                       !$message->intended_for
                       or $message->intended_for === $user->getKey()
                   );
        }

        return $message->receiver->getKey() === $user->getKey();
    }
}
