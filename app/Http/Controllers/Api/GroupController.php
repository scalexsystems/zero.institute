<?php namespace Scalex\Zero\Http\Controllers\Api;

use Illuminate\Http\Request;
use Scalex\Zero\Events\Group\MemberJoined;
use Scalex\Zero\Events\Group\MemberLeft;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Http\Requests;
use Scalex\Zero\Models\Group;

class GroupController extends Controller
{
    public function index(Request $request) {
        $groups = repository(Group::class);

        if ($request->has('q')) {
            $groups->search($request->query('q'));
        }

        return $groups->paginate();
    }

    public function show(Group $group) {
        $this->authorize($group);

        return $group;
    }

    public function members(Request $request, Group $group) {
        return repository($group)->useRelation('members')->simplePaginate();
    }

    public function store(Request $request) {
        $this->authorize('store', Group::class);

        repository(Group::class)->create(
            [
                'owner' => $request->user(),
                'school' => $request->user()->school,
                'owner_id' => $request->user()->getKey(),
                'school_id' => $request->user()->school->getKey(),
            ] + $request->all());

        return $this->created();
    }

    public function addMember(Request $request, Group $group) {
        $this->authorize($group);

        $ids = (array)$request->input('members', []);
        $ids = $group->filterNonMemberIds($ids);

        if (count($ids)) {
            $group->members()->attach($ids);
            event(new MemberJoined($ids, $group));
        }

        return $this->accepted();
    }

    public function removeMember(Request $request, Group $group) {
        $this->authorize($group);

        $ids = (array)$request->input('members', []);
        $ids = $group->filterMemberIds($ids);

        if (count($ids)) {
            $group->members()->detach($ids);
            event(new MemberLeft($ids, $group));
        }

        return $this->accepted();
    }

    public function update(Request $request, Group $group) {
        $this->authorize($group);

        repository($group)->update($group, $request->all());

        return $this->accepted();
    }
}
