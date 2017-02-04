<?php namespace Scalex\Zero\Policies;

use Scalex\Zero\User;

class UserPolicy extends AbstractPolicy
{
    /**
     * Check if User can see other users email.
     *
     * @param \Scalex\Zero\User $user
     * @param \Scalex\Zero\User $resource
     *
     * @return bool
     */
    public function readEmail(User $user, User $resource)
    {
        return $user->getKey() === $resource->getKey();
    }

    /**
     * Check if User can upload a file.
     *
     * @param \Scalex\Zero\User $user
     *
     * @return bool
     */
    public function uploadFile(User $user)
    {
        return true;
    }

    /**
     * Check if User can view conversation with.
     *
     * @return bool
     */
    public function viewConversation()
    {
        return true;
    }

    /**
     * Check if User can send message to.
     *
     * @return bool
     */
    public function sendMessage()
    {
        return true;
    }
}
