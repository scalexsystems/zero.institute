<?php

namespace Scalex\Zero\Http\Controllers\Api\Groups;

use Illuminate\Http\Request;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\Group;
use Znck\Attach\Builder;
use Ramsey\Uuid\Uuid;

class PhotoController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api,web');
    }

    public function store(Request $request, Group $group) {
        $this->authorize('update-group-photo', $group);
        $this->validate($request, ['photo' => 'required|image|max:10240']);

        $schoolId = $request->user()->school_id;
        $groupId = $group->getKey();
        $slug = Uuid::uuid4();
        $path = "schools/${schoolId}/groups/${groupId}";

        $photo = Builder::make($request, 'photo')
                        ->resize(300, null, 300)
                        ->upload(compact('slug', 'path'))
                        ->getAttachment();

        if (!$photo->exists) {
            abort(500, 'Your photo just broke our servers.');
        }

        repository(Group::class)->update($group, ['photo_id' => $photo->id]);

        return $this->accepted(attach_url($photo));
    }

    public function destroy(Request $request, Group $group) {
        $this->authorize('remove-group-photo', $group);

        repository(Group::class)->update($group, ['photo_id' => null]);

        return $this->accepted();
    }
}
