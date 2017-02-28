<?php

namespace Scalex\Zero\Http\Controllers\Api\Groups;

use Illuminate\Http\Request;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\Group;
use Scalex\Zero\Repositories\GroupRepository;

class ProfilePhotoController extends Controller
{
    /**
     * Add auth middleware to all routes.
     */
    public function __construct()
    {
        $this->middleware('auth:api,web');
    }

    /**
     * Update group photo.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Scalex\Zero\Models\Group $group
     * @param \Scalex\Zero\Repositories\GroupRepository $repository
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Group $group, GroupRepository $repository)
    {
        $this->authorize('update-profile-photo', $group);

        $this->validate($request, ['photo' => 'required|image|max:10240']);

        $photo = $repository->updatePhoto($group, $request->file('photo'), $request->user());

        return $this->accepted(attach_url($photo));
    }

    /**
     * Remove group photo.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Scalex\Zero\Models\Group $group
     * @param \Scalex\Zero\Repositories\GroupRepository $repository
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Group $group, GroupRepository $repository)
    {
        $this->authorize('remove-profile-photo', $group);

        $repository->removePhoto($group);

        return $this->accepted();
    }
}
