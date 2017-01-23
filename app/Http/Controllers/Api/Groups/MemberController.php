<?php namespace Scalex\Zero\Http\Controllers\Api\Groups;

use Illuminate\Http\Request;
use Scalex\Zero\Events\Group\MemberJoined;
use Scalex\Zero\Events\Group\MemberLeft;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\Group;
use Scalex\Zero\Models\Message;

class MemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api,web');
    }

    /**
     * Get members of the group.
     * GET /groups/{group}/members
     * Requires: auth
     */
    public function index(Group $group, Request $request)
    {
        $this->authorize('members', $group);

        $members = $group->members();

        // TODO: Add support to search here.

        $members->orderBy('name');

        $paginator = $members->paginate();
        $collection = $paginator->getCollection();

        $collection->load(['person', 'profilePhoto']);

        return $paginator;
    }

    /**
     * Add members to the group.
     * POST /groups/{group}/add
     * Requires: auth
     */
    public function store(Group $group, Request $request)
    {
        $this->authorize('add-member', $group);

        $result = $group->addMembers((array)$request->get('members', []));

        if (count($result['ids'])) {
            event(new MemberJoined($result['ids'], $group));
        }

        return [
            'data' => $result['ids'],
        ];
    }

    /**
     * Remove members from the group.
     * DELETE /groups/{group}/remove
     * Requires: auth
     */
    public function destroy(Group $group, Request $request)
    {
        $this->authorize($group);

        $result = $group->removeMembers((array)$request->get('members', []));

        if (count($result['ids'])) {
            event(new MemberLeft($result['ids'], $group));
        }

        return [
            'data' => $result['ids'],
        ];
    }
}
