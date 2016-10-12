<?php namespace Scalex\Zero\Http\Controllers\Api;

use Illuminate\Http\Request;
use Scalex\Zero\Criteria\OrderBy;
use Scalex\Zero\Events\Group\MemberJoined;
use Scalex\Zero\Events\Group\MemberLeft;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Http\Requests;
use Scalex\Zero\Models\Group;

class GroupController extends Controller
{
    public function index(Request $request) {
        $groups = repository(Group::class)->with('profilePhoto');

        if ($request->has('q')) {
            $groups->search($request->query('q'));
        } else {
            $groups->pushCriteria(new OrderBy('name'));
        }

        return $groups->simplePaginate();
    }

    public function show(Group $group) {
        $this->authorize($group);

        return $group;
    }

    public function members(Request $request, Group $group) {
        $members = $group->members();

        if ($request->has('q')) {
            $q = $request->get('q');
            $members->where('name', 'ilike', "%${q}%");
        }

        $members->orderBy('name');

        return $members->paginate();
    }

    public function store(Request $request) {
        $this->authorize('store', Group::class);

        $group = repository(Group::class)->create(
            [
                'owner' => $request->user(),
                'school' => $request->user()->school,
                'owner_id' => $request->user()->getKey(),
                'school_id' => $request->user()->school->getKey(),
            ] + $request->all());
        $group->members()->attach($request->user());

        return $this->created($group->getKey());
    }

    public function addMember(Request $request, Group $group) {
        $this->authorize($group);

        $result = $group->addMembers((array)$request->get('members', []));

        if (count($result['ids'])) {
            event(new MemberJoined($result['ids'], $group));
        }

        return response()->json($result, 202);
    }

    public function removeMember(Request $request, Group $group) {
        $this->authorize($group);

        $result = $group->removeMembers((array)$request->get('members', []));

        if (count($result['ids'])) {
            event(new MemberLeft($result['ids'], $group));
        }

        return response()->json($result, 202);
    }

    public function update(Request $request, Group $group) {
        $this->authorize($group);

        repository($group)->update($group, $request->all());

        return $this->accepted();
    }
}
