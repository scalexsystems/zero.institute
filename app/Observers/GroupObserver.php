<?php namespace Scalex\Zero\Observers;

use Scalex\Zero\Events\Group\Created;
use Scalex\Zero\Events\Group\Deleted;
use Scalex\Zero\Events\Group\Updated;
use Scalex\Zero\Events\Group\MemberLeft;
use Scalex\Zero\Models\Group;

class GroupObserver
{
    /**
     * Created hook.
     *
     * @param \Scalex\Zero\Models\Group $group
     */
    public function created(Group $group)
    {
        if (!$group->isMember($group->owner)) {
            $group->addMembers($group->owner);
        }
    }

    /**
     * Created hook.
     *
     * @param \Scalex\Zero\Models\Group $group
     */
    public function updated(Group $group)
    {
        if (!$group->isMember($group->owner)) {
            $group->addMembers($group->owner);
        }
    }
}
