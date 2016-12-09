<?php namespace Scalex\Zero\Http\Controllers\Api\Groups;

use Illuminate\Http\Request;
use Scalex\Zero\Criteria\OrderBy;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Http\Requests;
use Scalex\Zero\Models\Group;

class GroupController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api,web');
    }

    /**
     * List all groups.
     * GET /groups
     * Requires: auth
     */
    public function index(Request $request) {
        $groups = repository(Group::class)
            ->with('profilePhoto')
            ->pushCriteria(criteria(function ($query) {
                /** @var \Illuminate\Database\Query\Builder $query */
                $query->where('private', false);
            }));

        if ($request->has('q')) {
            $groups->search($request->query('q'));
        } else {
            $groups->pushCriteria(new OrderBy('name'));
        }

        return $groups->paginate();
    }

    /**
     * Get group details.
     * GET /groups/{group}
     * Requires: auth
     */
    public function show(Group $group) {
        $this->authorize('show', $group);

        return $group;
    }

    /**
     * Create new group.
     * POST /groups
     * Requires: auth
     */
    public function store(Request $request) {
        $this->authorize('store', Group::class);

        $group = repository(Group::class)->create(
            [
                'owner' => $request->user(),
                'school' => $request->user()->school,
                'owner_id' => $request->user()->getKey(),
                'school_id' => $request->user()->school->getKey(),
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'private' => $request->input('private', false),
            ]);

        $members = $request->input('members', []);

        if (count($members)) {
            array_push($members, $request->user()->id);
            $group->addMembers($members);
        } else {
            $group->addMembers([$request->user()->id]);
        }


        return $group;
    }

    /**
     * Update group details.
     * PUT /groups/{group}
     * Requires: auth
     */
    public function update(Request $request, Group $group) {
        $this->authorize('update', $group);

        repository(Group::class)->update($group, $request->all()); // FIXME: This is blunt.

        return $group;
    }

    public function destroy(Group $group) {
        $this->authorize('delete', $group);

        repository(Group::class)->delete($group);

        return $this->accepted();
    }
}
