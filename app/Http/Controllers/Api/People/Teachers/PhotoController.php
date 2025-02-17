<?php namespace Scalex\Zero\Http\Controllers\Api\People\Teachers;

use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Scalex\Zero\Events\Teacher\PhotoUpdated;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\Student;
use Scalex\Zero\Models\Teacher;
use Scalex\Zero\Repositories\TeacherRepository;
use Znck\Attach\Builder;

class PhotoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api,web');
    }

    public function show(Teacher $teacher)
    {
        $this->authorize('view-photo', $teacher);

        return $teacher->photo ?? [];
    }

    public function store(Request $request, Teacher $teacher, TeacherRepository $repository)
    {
        $this->authorize('update-photo', $teacher);
        $this->validate($request, ['photo' => 'required|file|mimes:jpeg,png|max:10240']);

        $user = $request->user();

        $repository->uploadPhoto($teacher, $request->file('photo'), $user);

        if ($teacher->user->getKey() === $user->getKey()) {
            $user->photo_id = $teacher->photo_id;

            $user->save();
        }

        broadcast(new PhotoUpdated($teacher));

        return $this->accepted($teacher->getPhotoUrl());
    }
}
