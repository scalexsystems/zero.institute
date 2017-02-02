<?php namespace Scalex\Zero\Http\Controllers\Api\Groups;

use Illuminate\Http\Request;
use Scalex\Zero\Events\Group\MemberJoined;
use Scalex\Zero\Events\Group\MemberLeft;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\Group;
use Scalex\Zero\Models\Message;
use Scalex\Zero\Repositories\GroupRepository;

class MemberController extends Controller
{
    /**
     * Add auth middleware for all routes.
     */
    public function __construct()
    {
        $this->middleware('auth:api,web');
    }

    /**
     * List group members.
     *
     * @param \Scalex\Zero\Models\Group $group
     * @param \Scalex\Zero\Repositories\GroupRepository $repository
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index(Group $group, GroupRepository $repository)
    {
        $this->authorize('view-members', $group);

        return $repository->members($group);
    }

    /**
     * Add members to the group.
     *
     * @param \Scalex\Zero\Models\Group $group
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function store(Group $group, Request $request)
    {
        $this->authorize('add-members', $group);

        $members = $group->addMembers($request->input('members'));

        if (count($members)) {
            event(new MemberJoined($group, $members));
        }

        return $members->toArray();
    }

    /**
     * Remove members from the group.
     *
     * @param \Scalex\Zero\Models\Group $group
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function destroy(Group $group, Request $request)
    {
        $this->authorize('remove-members', $group);

        $members = $group->removeMembers($request->get('members'));

        if (count($members)) {
            event(new MemberLeft($group, $members));
        }

        return $members->toArray();
    }
}
