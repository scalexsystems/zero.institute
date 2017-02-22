<?php namespace Scalex\Zero\Http\Controllers\Api\People\Teachers;

use Illuminate\Http\Request;
use Scalex\Zero\Criteria\OfDepartment;
use Scalex\Zero\Criteria\OrderBy;
use Scalex\Zero\Events\Teacher\Updated;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\Teacher;
use Scalex\Zero\Jobs\SendInvitations;
use Scalex\Zero\Repositories\TeacherRepository;

class TeacherController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api,web');
    }

    public function index(Request $request, TeacherRepository $repository)
    {
        $this->authorize('browse', Teacher::class);

        $repository->with(['photo', 'user'])
                   ->pushCriteria(new OfDepartment($request->input('department')));

        if ($request->has('q')) {
            $repository->search($request->input('q'));
        } else {
            $repository->pushCriteria(new OrderBy(['first_name', 'last_name']));
        }

        return $repository->simplePaginate();
    }

    public function show(Request $request, Teacher $teacher)
    {
        $this->authorize('view', $teacher);

        return transform($teacher, ['photo', 'address'], null, true);
    }

    public function store()
    {
        abort(401);
    }

    public function update(Request $request, Teacher $teacher)
    {
        $this->authorize('update', $teacher);

        $teacher = repository(Teacher::class)->update($teacher, $request->all());

        broadcast(new Updated($teacher));

        return $teacher;
    }

    public function destroy()
    {
        abort(401);
    }
}
