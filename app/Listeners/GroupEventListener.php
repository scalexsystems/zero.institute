<?php namespace Scalex\Zero\Listeners;

use Scalex\Zero\Events\Group\MemberJoined;
use Scalex\Zero\Events\Group\MemberLeft;
use Scalex\Zero\Models\Group;

class GroupEventListener
{
    public function onMemberCountChanged(Group $group) {
        $group->count_members = $group->members()->count();
        $group->save();
    }

    public function onMemberJoined(MemberJoined $event) {
        $this->onMemberCountChanged($event->getGroup());
    }

    public function onMemberLeft(MemberLeft $event) {
        $this->onMemberCountChanged($event->getGroup());
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events) {
        $events->listen(MemberJoined::class, self::class.'@onMemberJoined');
        $events->listen(MemberLeft::class, self::class.'@onMemberLeft');
    }
}
