<?php namespace Scalex\Zero\Policies;

use Scalex\Zero\Models\Group;
use Scalex\Zero\User;

class GroupPolicy extends AbstractPolicy
{
    /**
     * Whether user can see details of the group.
     *
     * @param \Scalex\Zero\User $user
     * @param \Scalex\Zero\Models\Group $group
     *
     * @return bool
     */
    public function view(User $user, Group $group) {
        return $this->isPublic($group) or $group->isMember($user);
    }

    /**
     * Whether user can create new group.
     *
     * @param \Scalex\Zero\User $user
     *
     * @return bool
     */
    public function create(User $user) {
        // Anyone can create a group.
        return !is_null($user->person_id);
    }

    /**
     * Whether user can update the group details.
     *
     * @param \Scalex\Zero\User $user
     * @param \Scalex\Zero\Models\Group $group
     *
     * @return bool
     */
    public function update(User $user, Group $group) {
        return $this->isOwner($group);
    }

    /**
     * Whether user can delete the group.
     *
     * @param \Scalex\Zero\User $user
     * @param \Scalex\Zero\Models\Group $group
     *
     * @return bool
     */
    public function delete(User $user, Group $group) {
        return $this->isOwner($group);
    }

    /**
     * Whether user can see group members.
     *
     * @param \Scalex\Zero\User $user
     * @param \Scalex\Zero\Models\Group $group
     *
     * @return bool
     */
    public function viewMembers(User $user, Group $group) {
        return $this->isPublic($group) or $group->isMember($user);
    }

    /**
     * Whether user can add members to the group.
     *
     * @param \Scalex\Zero\User $user
     * @param \Scalex\Zero\Models\Group $group
     *
     * @return bool
     */
    public function addMembers(User $user, Group $group) {
        return $this->isOwner($group);
    }

    /**
     * Whether user can remove members from the group.
     *
     * @param \Scalex\Zero\User $user
     * @param \Scalex\Zero\Models\Group $group
     *
     * @return bool
     */
    public function removeMembers(User $user, Group $group) {
        return $this->isOwner($group);
    }

    /**
     * Whether user can see group messages.
     *
     * @param \Scalex\Zero\User $user
     * @param \Scalex\Zero\Models\Group $group
     *
     * @return bool
     */
    public function viewMessages(User $user, Group $group) {
        return $group->isMember($user);
    }

    /**
     * Whether user can send message to the group.
     *
     * @param \Scalex\Zero\User $user
     * @param \Scalex\Zero\Models\Group $group
     *
     * @return bool
     */
    public function sendMessage(User $user, Group $group) {
        return $group->isMember($user);
    }

    /**
     * Whether user can update group photo.
     *
     * @param \Scalex\Zero\User $user
     * @param \Scalex\Zero\Models\Group $group
     *
     * @return bool
     */
    public function updateProfilePhoto(User $user, Group $group) {
        return $this->isOwner($group);
    }

    /**
     * Whether user can remove group photo.
     *
     * @param \Scalex\Zero\User $user
     * @param \Scalex\Zero\Models\Group $group
     *
     * @return bool
     */
    public function removeProfilePhoto(User $user, Group $group) {
        return $this->isOwner($group);
    }

    /**
     * Whether user can upload files to the group.
     *
     * @param \Scalex\Zero\User $user
     * @param \Scalex\Zero\Models\Group $group
     *
     * @return bool
     */
    public function uploadFileIn(User $user, Group $group) {
        return $group->isMember($user);
    }

    /**
     * Whether user can join a group.
     *
     * @param \Scalex\Zero\User $user
     * @param \Scalex\Zero\Models\Group $group
     *
     * @return bool
     */
    public function join(User $user, Group $group) {
        return $this->isPublic($group);
    }

    /**
     * Whether user can leave a group.
     *
     * @param \Scalex\Zero\User $user
     * @param \Scalex\Zero\Models\Group $group
     *
     * @return bool
     */
    public function leave(User $user, Group $group) {
        if ($this->isOwner($group)) {
            return false;
        }

        if (hash_equals('course', $group->type)) {
            return false;
        }

        return $group->isMember($user);
    }

    /**
     * Whether user can update message state in the group.
     *
     * @param \Scalex\Zero\User $user
     * @param \Scalex\Zero\Models\Group $group
     *
     * @return bool
     */
    public function readMessages(User $user, Group $group) {
        return $group->isMember($user);
    }

    /**
     * Is user owner?
     *
     * @param Group $group
     *
     * @return bool
     */
    protected function isOwner(Group $group) {
        return $this->getUser()->getKey() === (int) $group->owner_id;
    }

    /**
     * Is group public?
     *
     * @param Group $group
     *
     * @return bool
     */
    protected function isPublic(Group $group) {
        return ! $group->private and (
            is_null($group->school_id) or $group->school_id === (int) $this->getUser()->school_id
        );
    }
}
