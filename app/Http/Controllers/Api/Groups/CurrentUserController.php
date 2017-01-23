<?php namespace Scalex\Zero\Http\Controllers\Api\Groups;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Scalex\Zero\Events\Group\MemberJoined;
use Scalex\Zero\Events\Group\MemberLeft;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\Group;

class CurrentUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api,web');
    }

    /**
     * List joined groups.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        if ($request->has('q') and is_numeric($q = $request->query('q'))) {
            $groups = Group::with('profilePhoto', 'lastMessageAt')->where('id', $q)->get();

            if ($groups->first()->isMember($user)) {
                return $groups;
            }
        }

        $groups = $user->groups()->orderBy('name')->paginate();
        $groups->getCollection()->load('profilePhoto', 'lastMessageAt');

        return $groups;
    }

    public function show(Request $request, Group $group)
    {
        if (!$group->isMember($request->user())) {
            abort(404);
        }

        return $group;
    }

    /**
     * Join group.
     */
    public function store(Group $group)
    {
        $this->authorize('join', $group);

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
        return $group;
    }

    /**
     * Leave group.
     */
    public function delete(Group $group)
    {
        $this->authorize('leave', $group);

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
