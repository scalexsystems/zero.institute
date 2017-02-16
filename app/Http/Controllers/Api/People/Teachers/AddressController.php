<?php namespace Scalex\Zero\Http\Controllers\Api\People\Teachers;

use Illuminate\Http\Request;
use Scalex\Zero\Events\Teacher\Updated;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\Teacher;
use Scalex\Zero\Repositories\TeacherRepository;

class AddressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api,web');
    }

    public function show(Teacher $teacher)
    {
        $this->authorize('view-address', $teacher);

        return $teacher->address ?? [];
    }

    public function update(Request $request, Teacher $teacher, TeacherRepository $repository)
    {
        $this->authorize('update-address', $teacher);

        $repository->updateAddress($teacher, $request->all());

        broadcast(new Updated($teacher));

        return $teacher->address;
    }
}
