<?php namespace Scalex\Zero\Http\Controllers\Api\People\Students;

use Illuminate\Http\Request;
use Scalex\Zero\Events\Student\StudentPhotoUpdated;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\Student;
use Scalex\Zero\Repositories\StudentRepository;

class PhotoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api,web');
    }

    public function show(Student $student)
    {
        $this->authorize('view-photo', $student);

        return $student->photo ?? [];
    }

    public function store(Request $request, Student $student, StudentRepository $repository)
    {
        $this->authorize('update-photo', $student);
        $this->validate($request, ['photo' => 'required|image|max:10240']);

        $user = $request->user();
        $repository->uploadPhoto($student, $request->file('photo'), $user);

        if ($student->user->getKey() === $user->getKey()) {
            $user->photo_id = $student->photo_id;

            $user->save();
        }

        broadcast(new StudentPhotoUpdated($student));

        return $this->accepted($student->getPhotoUrl());
    }
}
