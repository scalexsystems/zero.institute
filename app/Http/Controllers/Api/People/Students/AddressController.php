<?php namespace Scalex\Zero\Http\Controllers\Api\People\Students;

use Illuminate\Http\Request;
use Scalex\Zero\Events\Student\StudentAddressUpdated;
use Scalex\Zero\Events\Student\Updated;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\Student;
use Scalex\Zero\Repositories\StudentRepository;

class AddressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api,web');
    }

    public function show(Student $student)
    {
        $this->authorize('view-address', $student);

        return $student->address ?? [];
    }

    public function update(Request $request, Student $student, StudentRepository $repository)
    {
        $this->authorize('update-address', $student);

        $repository->updateAddress($student, $request->all());

        broadcast(new Updated($student));

        return $student->address;
    }
}
