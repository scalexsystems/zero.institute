<?php namespace Scalex\Zero\Http\Controllers\Api\Schools;

use Ramsey\Uuid\Uuid;
use Scalex\Zero\Repositories\SchoolRepository;
use Znck\Attach\Builder;
use Znck\Attach\Processors\Resize;
use Illuminate\Http\Request;
use Scalex\Zero\Models\Group;
use Scalex\Zero\Models\Message;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\User;

class FileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api,web');
    }

    /**
     * Create new file.
     * POST /school/logo
     * Requires: auth
     */
    public function store(Request $request, SchoolRepository $repository)
    {
        $school = $request->user()->school;
        $this->authorize('update-photo', $school);
        $this->validate($request, ['photo' => 'required|image|max:10240']);

        $user = $request->user();
        $repository->uploadPhoto($school, $request->file('photo'), $user);

        return $this->accepted($school->getPhotoUrl());
    }
}
