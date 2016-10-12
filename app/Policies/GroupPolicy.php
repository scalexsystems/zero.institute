<?php namespace Scalex\Zero\Policies;

use Scalex\Zero\Models\Group;
use Scalex\Zero\User;

class GroupPolicy extends AbstractPolicy
{
    public function view(User $user, Group $group) {
        return !$group->private or $group->isMember($user);
    }

    public function store(User $user) {
        return !is_null($user->person_id);
    }

    public function update(User $user, Group $group) {
        return $this->isOwner($user, $group);
    }

    public function delete(User $user, Group $group) {
        return $this->isOwner($user, $group);
    }

    public function addMember(User $user, Group $group) {
        return $this->isOwner($user, $group);
    }

    public function removeMember(User $user, Group $group) {
        return $this->isOwner($user, $group);
    }

    public function join(User $user, Group $group) {
        return is_null($group->school_id)
            or !$group->private
            or verify_school($user, $group);
    }

    public function leave(User $user, Group $group) {
        return $group->isMember($user);
    }

    /**
     * @param \Scalex\Zero\User $user
     * @param \Scalex\Zero\Models\Group $group
     *
     * @return bool
     */
    protected function isOwner(User $user, Group $group):bool {
        return $group->owner_id === $user->getKey();
    }
}
