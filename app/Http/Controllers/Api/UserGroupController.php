<?php namespace Scalex\Zero\Http\Controllers\Api;

use Scalex\Zero\Events\Group\MemberJoined;
use Scalex\Zero\Events\Group\MemberLeft;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\Group;

class UserGroupController extends Controller
{
    public function index() {
        $user = current_user();

        return $user->groups()->orderBy('name')->paginate();
    }

    public function join(Group $group) {
        $this->authorize($group);

        $user = current_user();

        if ($group->isMember($user)) {
            abort(400, 'You are already member of this group.');
        }

        $result = $group->addMembers([$user->getKey()]);
        if (count($result['ids'])) {
            event(new MemberJoined($user, $group));
        } else {
            abort(400, 'You are not allowed to join this group.');
        }

        return $this->accepted();
    }

    public function leave(Group $group) {
        $this->authorize($group);

        $user = current_user();

        $result = $group->removeMembers([$user->getKey()]);
        if (count($result['ids'])) {
            event(new MemberLeft($user, $group));
        } else {
            abort(400, 'You cannot leave this group.');
        }

        return $this->accepted();
    }
}
