<?php namespace Scalex\Zero\Http\Controllers\Api\Messages\Direct;

use Illuminate\Http\Request;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Repositories\UserRepository;
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
