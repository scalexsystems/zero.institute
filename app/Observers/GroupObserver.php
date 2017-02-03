<?php namespace Scalex\Zero\Observers;

use Scalex\Zero\Events\Group\GroupCreated;
use Scalex\Zero\Events\Group\GroupDeleted;
use Scalex\Zero\Events\Group\GroupUpdated;
use Scalex\Zero\Models\Group;

class GroupObserver
{
    /**
     * Created hook.
     *
     * @param \Scalex\Zero\Models\Group $group
     */
    public function created(Group $group) {
        if (! $group->isMember($group->owner)) {
            $group->addMembers($group->owner);
        }
    }

    /**
     * Members added hook.
     *
     * @param \Scalex\Zero\Models\Group $group
     */
    public function membersAdded(Group $group) {
        $group->count_members = $group->members()->count();

        $group->save();
    }

    /**
     * Members removed hook.
     *
     * @param \Scalex\Zero\Models\Group $group
     */
    public function membersRemoved(Group $group) {
        $group->count_members = $group->members()->count();

        $group->save();
    }
}
