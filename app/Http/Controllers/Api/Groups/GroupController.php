<?php namespace Scalex\Zero\Http\Controllers\Api\Groups;

use Illuminate\Http\Request;
use Scalex\Zero\Criteria\Group\PrivateGroup;
use Scalex\Zero\Criteria\OrderBy;
use Scalex\Zero\Events\Group\GroupCreated;
use Scalex\Zero\Events\Group\GroupDeleted;
use Scalex\Zero\Events\Group\GroupUpdated;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Http\Requests;
use Scalex\Zero\Models\Group;
use Scalex\Zero\Repositories\GroupRepository;

class GroupController extends Controller
{
    /**
     * Add auth middleware for all routes.
     */
    public function __construct()
    {
        $this->middleware('auth:api,web');
    }

    /**
     * Search or index groups.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Scalex\Zero\Repositories\GroupRepository $repository
     *
     * @return mixed
     */
    public function index(Request $request, GroupRepository $repository)
    {
        $groups = $repository->with(['photo', 'lastMessage'])->pushCriteria(new PrivateGroup(false));

        if ($request->has('q')) {
            $groups->search($request->query('q'));
        } else {
            $groups->pushCriteria(new OrderBy('name'));
        }

        return $groups->paginate();
    }

    /**
     * Show group details.
     *
     * @param \Scalex\Zero\Models\Group $group
     *
     * @return \Scalex\Zero\Models\Group
     */
    public function show(Group $group)
    {
        $this->authorize('view', $group);

        return $group;
    }

    /**
     * Create new group.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Scalex\Zero\Repositories\GroupRepository $repository
     *
     * @return \Scalex\Zero\Models\Group
     */
    public function store(Request $request, GroupRepository $repository)
    {
        $this->authorize('create', Group::class);

        $group = $repository->createWithMembers(
            $request->user(),
            $request->all(),
            (array)$request->input('members')
        );

        event(new GroupCreated($group));

        return $group;
    }

    /**
     * Update group details.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Scalex\Zero\Models\Group $group
     * @param \Scalex\Zero\Repositories\GroupRepository $repository
     *
     * @return \Scalex\Zero\Models\Group
     */
    public function update(Request $request, Group $group, GroupRepository $repository)
    {
        $this->authorize('update', $group);

        $attributes = $request->all();

        if ($group->isOfType('course')) {
            unset($attributes['private']);
        }

        $repository->update($group, $attributes);

        event(new GroupUpdated($group));

        return $group;
    }

    public function destroy(Group $group, GroupRepository $repository)
    {
        $this->authorize('delete', $group);

        if ($group->isOfType('course')) {
            abort(400, 'Course group cannot be deleted.');
        }

        $repository->delete($group);

        event(new GroupDeleted($group));

        return $this->accepted();
    }
}
