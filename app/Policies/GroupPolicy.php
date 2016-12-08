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

    public function members(User $user, Group $group) {
        return $group->private === false or $group->isMember($user);
    }

    public function messages(User $user, Group $group) {
        return $group->isMember($user);
    }

    public function send(User $user, Group $group) {
        return $group->isMember($user);
    }

    public function read(User $user, Group $group) {
        return $group->isMember($user);
    }

    public function join(User $user, Group $group) {
        return is_null($group->school_id)
               or !$group->private
               or verify_school($user, $group);
    }

    public function leave(User $user, Group $group) {
        if ($this->isOwner($user, $group)) {
            return false;
        }

        return $group->isMember($user);
    }

    public function updateGroupPhoto(User $user, Group $group) {
        return $this->isOwner($user, $group);
    }

    public function removeGroupPhoto(User $user, Group $group) {
        return $this->isOwner($user, $group);
    }

    protected function isOwner(User $user, Group $group): bool {
        return $group->owner_id === $user->getKey();
    }
}
