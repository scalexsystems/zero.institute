<?php namespace Scalex\Zero\Http\Controllers\Api\People\Employees;

use Illuminate\Http\Request;
use Scalex\Zero\Events\Employee\Updated;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\Employee;
use Scalex\Zero\Repositories\EmployeeRepository;

class AddressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api,web');
    }

    public function show(Employee $employee)
    {
        $this->authorize('view-address', $employee);

        return $employee->address ?? [];
    }

    public function update(Request $request, Employee $employee, EmployeeRepository $repository)
    {
        $this->authorize('update-address', $employee);

        $repository->updateAddress($employee, $request->all());

        broadcast(new Updated($employee));

        return $employee->address;
    }
}