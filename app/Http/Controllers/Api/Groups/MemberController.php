<?php namespace Scalex\Zero\Http\Controllers\Api\Groups;

use Illuminate\Http\Request;
use Illuminate\Support\Debug\Dumper;
use Scalex\Zero\Events\Group\MemberJoined;
use Scalex\Zero\Events\Group\MemberLeft;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\Group;
use Scalex\Zero\Models\Message;
use Scalex\Zero\Repositories\GroupRepository;
use Scalex\Zero\User;

class MemberController extends Controller
{
    /**
     * Add auth middleware for all routes.
     */
    public function __construct()
    {
        $this->middleware('auth:api,web');
    }

    public function index(Group $group, GroupRepository $repository)
    {
        $this->authorize('view-members', $group);

        return $repository->members($group);
    }

    public function store(Group $group, Request $request)
    {
        $this->authorize('add-members', $group);
        $this->validate($request, [
            'member' => 'required|exists:users,id',
        ]);

        $members = $group->addMembers((array)$request->input('member'));

        if (count($members)) {
            event(new MemberJoined($group, $members));
        }

        return User::find($members->toArray());
    }

    public function destroy(Group $group, Request $request)
    {
        $this->authorize('remove-members', $group);
        $this->validate($request, ['member' => 'required']);

        $members = $group->removeMembers($request->input('member'));

        if (count($members)) {
            event(new MemberLeft($group, $members));
        }

        return $members->toArray();
    }
}
