<?php namespace Scalex\Zero\Http\Controllers\Api\People\Students;

use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Scalex\Zero\Events\Student\StudentPhotoUpdated;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\Student;
use Scalex\Zero\Repositories\StudentRepository;
use Znck\Attach\Builder;

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

        $repository->uploadPhoto($student, $request->file('photo'), $request->user());

        broadcast(new StudentPhotoUpdated($student));

        return $this->accepted($student->getPhotoUrl());
    }
}
