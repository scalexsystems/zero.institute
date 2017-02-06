<?php namespace Scalex\Zero\Http\Controllers\Api\People\Employees;

use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\Employee;
use Scalex\Zero\Models\Student;
use Znck\Attach\Builder;

class PhotoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api,web');
    }

    public function store(Request $request, Employee $employee)
    {
        //        $this->authorize('update', $student);
        $this->validate($request, ['photo' => 'required|image|max:10240']);

        $schoolId = $request->user()->school_id;
        $studentId = $employee->getKey();
        $slug = Uuid::uuid4();
        $path = "schools/${schoolId}/user/${studentId}";

        $photo = Builder::make($request, 'photo')
            ->resize(300, null, 300)
            ->upload(compact('slug', 'path'))
            ->getAttachment();

        if (!$photo->exists) {
            abort(500, 'Your photo just broke our servers.');
        }
        return $photo;
    }
}
