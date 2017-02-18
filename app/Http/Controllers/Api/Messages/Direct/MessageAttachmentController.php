<?php namespace Scalex\Zero\Http\Controllers\Api\Messages\Direct;

use Ramsey\Uuid\Uuid;
use Scalex\Zero\Repositories\UserRepository;
use Znck\Attach\Builder;
use Znck\Attach\Processors\Resize;
use Illuminate\Http\Request;
use Scalex\Zero\Models\Group;
use Scalex\Zero\Models\Message;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\User;

class MessageAttachmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api,web');
    }

    /**
     * Upload
     *
     * @param \Illuminate\Http\Request $request
     * @param \Scalex\Zero\Repositories\UserRepository $repository
     *
     * @return \Scalex\Zero\Models\Attachment
     */
    public function store(Request $request, UserRepository $repository)
    {
        $this->authorize('upload-file', User::class);

        return $repository->uploadMessageAttachment($request->user(), $request->file('file'), $request->except('file'));
    }
}
