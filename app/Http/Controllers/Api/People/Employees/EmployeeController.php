<?php namespace Scalex\Zero\Http\Controllers\Api\People\Employees;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Scalex\Zero\Criteria\OrderBy;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Mail\InvitationMail;
use Scalex\Zero\Models\Employee;
use Scalex\Zero\Jobs\SendInvitations;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api,web');
    }

    public function index(Request $request)
    {
        $employees = repository(Employee::class)->with('profilePhoto');

        if ($request->has('q')) {
            $employees->search($request->input('q'));
        } else {
            $employees->pushCriteria(new OrderBy(['first_name', 'last_name']));
        }

        return $employees->simplePaginate();
    }

    public function show(Request $request, $employee)
    {
        $employee = repository(Employee::class)->findBy('uid', $employee);
        $this->authorize($employee);

        $request->query->set('with', ['profilePhoto', 'address']);

        return $employee;
    }

    public function update(Request $request, Employee $employee)
    {
        $this->authorize($employee);
        $data = $request->all();
        repository(Employee::class)->update($employee, $data);
        $this->accepted();
    }

    public function invite(Request $request)
    {
        $this->authorize('invite', Employee::class);
        $this->validate($request, [
            'employees.*' => 'required | email',
        ]);

        dispatch(new SendInvitations('employee', $request->employees, $request->user()->school_id, $request->user()));
    }
}
