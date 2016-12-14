<?php namespace Scalex\Zero\Http\Controllers\Api\Groups;


use Ramsey\Uuid\Uuid;
use Znck\Attach\Builder;
use Illuminate\Http\Request;
use Scalex\Zero\Models\Group;
use Scalex\Zero\Models\Message;
use Scalex\Zero\Http\Controllers\Controller;

class FileController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api,web');
    }
    /**
     * Create new file.
     * POST /groups/{group}/file
     * Requires: auth
     */
    public function store(Request $request, Group $group) {
        $this->authorize('upload-file', $group);
        $this->validate($request, ['file' => 'required']);

        $schoolId = $request->user()->school_id;
        $groupId = $group->getKey();
        $slug = Uuid::uuid4();
        $path = "schools/${schoolId}/groups/${groupId}";

        $file = Builder::make($request, 'file')
            ->resize(300, null, 300)
            ->upload(compact('slug', 'path'))
            ->getAttachment();

        if (!$file->exists) {
            abort(500, 'Your file just broke our servers.');
        }

        return $file;

    }
}