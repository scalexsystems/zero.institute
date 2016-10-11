<?php namespace Scalex\Zero\Http\Controllers\Api;

use Scalex\Zero\Events\Group\MemberJoined;
use Scalex\Zero\Events\Group\MemberLeft;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\Group;

class UserGroupController extends Controller
{
    public function join(Group $group) {
        $this->authorize($group);

        $user = current_user();
        if ($group->isMember($user)) {
            abort(400, 'You are already member of this group.');
        }
        $group->members()->attach($user);
        event(new MemberJoined($user, $group));

        return $this->accepted();
    }

    public function leave(Group $group) {
        $this->authorize($group);

        $user = current_user();
        if (!$group->isMember($user)) {
            abort(400, 'You are not a member of this group.');
        }
        $group->members()->detach($user);
        event(new MemberLeft($user, $group));

        return $this->accepted();
    }
}
