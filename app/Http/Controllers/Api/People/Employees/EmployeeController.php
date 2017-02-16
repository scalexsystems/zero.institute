<?php namespace Scalex\Zero\Http\Controllers\Api\People\Employees;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Scalex\Zero\Criteria\OrderBy;
use Scalex\Zero\Events\Employee\Updated;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Mail\InvitationMail;
use Scalex\Zero\Models\Employee;
use Scalex\Zero\Jobs\SendInvitations;
use Scalex\Zero\Repositories\EmployeeRepository;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api,web');
    }

    public function index(Request $request, EmployeeRepository $repository)
    {
        $this->authorize('browse', Employee::class);
        $repository->with(['photo', 'user']);

        if ($request->has('q')) {
            $repository->search($request->input('q'));
        } else {
            $repository->pushCriteria(new OrderBy(['first_name', 'last_name']));
        }

        return $repository->simplePaginate();
    }

    public function show(Request $request, Employee $employee)
    {
        $this->authorize('view', $employee);
        return transform($employee, ['photo', 'address'], null, true);
    }

    public function update(Request $request, Employee $employee)
    {
        $this->authorize('update', $employee);

        repository(Employee::class)->update($employee, $request->all());

        broadcast(new Updated($employee));

        return $employee;
    }

    public function store()
    {
        abort(401);
    }

}
