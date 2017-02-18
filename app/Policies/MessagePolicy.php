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
        // Hey! I'm the sender.
        if ((int) $message->sender_id === $user->getKey()) {
            return true;
        }

        // is sent to a group?
        if ($message->receiver instanceof Group) {
            // Should be member of the group.
            return $message->receiver->isMember($user) and
                   (
                       // Either intended for no one.
                       $message->intended_for === null or
                       // Or intended for the user.
                       (int)$message->intended_for === $user->getKey()
                   );
        }

        // Else it should be the user!
        return (int)$message->receiver->getKey() === $user->getKey();
    }
}
