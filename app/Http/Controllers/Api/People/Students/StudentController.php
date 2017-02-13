<?php namespace Scalex\Zero\Http\Controllers\Api\People\Students;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Scalex\Zero\Criteria\OfDepartment;
use Scalex\Zero\Criteria\OfDiscipline;
use Scalex\Zero\Criteria\OrderBy;
use Scalex\Zero\Events\Student\StudentUpdated;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Http\Requests;
use Scalex\Zero\Models\Student;
use Scalex\Zero\Jobs\SendInvitations;
use Scalex\Zero\Repositories\StudentRepository;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api,web');
    }

    public function index(Request $request, StudentRepository $repository)
    {
        $this->authorize('browse', Student::class);

        $repository->with(['photo', 'user'])
                   ->pushCriteria(new OfDepartment($request->input('department')))
                   ->pushCriteria(new OfDiscipline($request->input('discipline')));

        if ($request->has('q')) {
            $repository->search($request->input('q'));
        } else {
            $repository->pushCriteria(new OrderBy(['first_name', 'last_name']));
        }

        return $repository->simplePaginate();
    }

    public function show(Request $request, Student $student)
    {
        $this->authorize('view', $student);

        return transform($student, ['photo', 'address', 'mother', 'father'], null, true);
    }

    public function store()
    {
        abort(401);
    }

    public function update(Request $request, Student $student)
    {
        $this->authorize('update', $student);

        repository(Student::class)->update($student, $request->all());

        broadcast(new StudentUpdated($student));

        return $student;
    }

    public function destroy()
    {
        abort(401);
    }
}
