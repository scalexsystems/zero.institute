<?php namespace Scalex\Zero\Http\Controllers\Api\People\Employees;

use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Scalex\Zero\Events\Employee\PhotoUpdated;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\Employee;
use Scalex\Zero\Models\Student;
use Scalex\Zero\Repositories\EmployeeRepository;
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

    public function store(Request $request, Employee $employee, EmployeeRepository $repository)
    {
        $this->authorize('update-photo', $employee);
        $this->validate($request, ['photo' => 'required|file|mimes:jpeg,png|max:10240']);

        $user = $request->user();
        $repository->uploadPhoto($employee, $request->file('photo'), $user);

        if ($employee->user->getKey() === $user->getKey()) {
            $user->photo_id = $employee->photo_id;

            $user->save();
        }

        broadcast(new PhotoUpdated($employee));

        return $this->accepted($employee->getPhotoUrl());
    }
}
