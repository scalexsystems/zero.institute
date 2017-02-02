<?php namespace Scalex\Zero\Http\Controllers\Api\Messages\Direct;

use Ramsey\Uuid\Uuid;
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
     * POST /groups/{group}/file
     * Requires: auth
     */
    public function store(Request $request)
    {
        $this->validate($request, ['file' => 'required']);

        $schoolId = $request->user()->school_id;
        $userId = $request->user()->id;
        $title = $request->input('title');
        $slug = Uuid::uuid4();
        $path = "schools/${schoolId}/messages/attachments/${userId}";

        $uploader = Builder::make($request, 'file');

        if ($this->isImage($request->file('file'))) {
            $uploader->resize(4096)->resize(450, 'preview');
        }

        $file = $uploader
            ->upload(compact('slug', 'path', 'title'))
            ->getAttachment();

        if (!$file->save()) {
            abort(500, 'Your file just broke our servers.');
        }

        return $file;
    }

    protected function isImage($file)
    {
        return in_array($file->guessExtension(), ['jpeg', 'png', 'gif', 'bmp']);
    }
}
