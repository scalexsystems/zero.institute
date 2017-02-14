<?php namespace Scalex\Zero\Http\Controllers\Api\People\Students;

use Illuminate\Http\Request;
use Scalex\Zero\Events\Student\StudentUpdated;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\Student;
use Scalex\Zero\Repositories\StudentRepository;

class GuardianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api,web');
    }

    public function father(Student $student)
    {
        $this->authorize('view-guardian', $student);

        return $student->father;
    }

    public function updateFather(Request $request, Student $student, StudentRepository $repository)
    {
        $this->authorize('update-guardian', $student);

        $repository->updateFather($student, $request->all());

        broadcast(new StudentUpdated($student));

        return $student->father;
    }

    public function mother(Student $student)
    {
        $this->authorize('view-guardian', $student);

        return $student->mother;
    }

    public function updateMother(Request $request, Student $student, StudentRepository $repository)
    {
        $this->authorize('update-guardian', $student);

        $repository->updateMother($student, $request->all());

        broadcast(new StudentUpdated($student, 'mother'));

        return $student->mother;
    }
}
