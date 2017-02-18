<?php namespace Scalex\Zero\Http\Controllers\Api\Groups;

use Illuminate\Http\Request;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\Group;
use Scalex\Zero\Repositories\GroupRepository;

class MessageAttachmentController extends Controller
{
    /**
     * Add auth middleware to all routes.
     */
    public function __construct()
    {
        $this->middleware('auth:api,web');
    }

    /**
     * Upload file in group.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Scalex\Zero\Models\Group $group
     * @param \Scalex\Zero\Repositories\GroupRepository $repository
     *
     * @return \Scalex\Zero\Models\Attachment
     */
    public function store(Request $request, Group $group, GroupRepository $repository)
    {
        $this->authorize('upload-file-in', $group);
        $this->validate($request, ['file' => 'required']);

        return $repository->uploadAttachment($group, $request->file('file'), $request->user(), $request->except('file'));
    }
}
