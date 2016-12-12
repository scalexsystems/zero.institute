<?php namespace Scalex\Zero\Http\Controllers\Api\Employees;

use Illuminate\Http\Request;
use Scalex\Zero\Criteria\OrderBy;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\Employee;

class EmployeeController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api,web');
    }

    public function index(Request $request) {
        $employees = repository(Employee::class)->with('profilePhoto');

        if ($request->has('q')) {
            $employees->search($request->input('q'));
        } else {
            $employees->pushCriteria(new OrderBy(['first_name', 'last_name']));
        }

        return $employees->simplePaginate();
    }

    public function show(Request $request, $employee) {
        $employee = repository(Employee::class)->findBy('uid', $employee);
        $this->authorize($employee);

        $request->query->set('with', ['profilePhoto', 'address']);

        return $employee;
    }
}
