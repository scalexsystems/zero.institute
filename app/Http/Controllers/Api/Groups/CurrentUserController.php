<?php namespace Scalex\Zero\Http\Controllers\Api\Groups;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Scalex\Zero\Criteria\Group\MessagesCount;
use Scalex\Zero\Events\Group\MemberJoined;
use Scalex\Zero\Events\Group\MemberLeft;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\Group;
use Scalex\Zero\Repositories\GroupRepository;

class CurrentUserController extends Controller
{
    /**
     * Add auth middleware to all routes.
     */
    public function __construct()
    {
        $this->middleware('auth:api,web');
    }

    /**
     * Get groups of current user.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Scalex\Zero\Repositories\GroupRepository $repository
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index(Request $request, GroupRepository $repository)
    {
        return $repository->groupsFor($request->user());
    }

    /**
     * Get group by ID.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Scalex\Zero\Models\Group $group
     *
     * @return \Scalex\Zero\Models\Group
     */
    public function show(Request $request, $group, GroupRepository $repository)
    {
        $group = $repository->pushCriteria(new MessagesCount())->find((int) $group);

        if (!$group->isMember($request->user())) {
            abort(404);
        }

        return $group;
    }

    /**
     * Join the group.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Scalex\Zero\Models\Group $group
     *
     * @return \Scalex\Zero\Models\Group
     */
    public function store(Request $request, Group $group)
    {
        $this->authorize('join', $group);

        $members = $group->addMembers($request->user());

        if (count($members)) {
            event(new MemberJoined($group, $members));
        }

        return $group;
    }

    /**
     * Leave the group.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Scalex\Zero\Models\Group $group
     *
     * @return \Scalex\Zero\Models\Group
     */
    public function delete(Request $request, Group $group)
    {
        $this->authorize('leave', $group);

        $members = $group->removeMembers($request->user());

        if (count($members)) {
            event(new MemberLeft($group, $members));
        }

        return $group;
    }
}
