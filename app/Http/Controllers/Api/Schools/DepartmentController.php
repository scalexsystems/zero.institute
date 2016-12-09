<?php namespace Scalex\Zero\Http\Controllers\Api\Schools;

use DB;
use Illuminate\Http\Request;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\Department;

class DepartmentController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api,web');
    }

    public function index(Request $request) {
        return cache()->rememberForever(
            schoolify('departments'),
            function () use ($request) {
                return $this->getPeopleCount($request);
            }
        );
    }

    public function store(Request $request) {
        $this->authorize('store', Department::class);

        $department = repository(Department::class)->create(
            [
                'school' => current_user()->school,
                'school_id' => current_user()->school_id,
            ] + $request->all() // FIXME: This is too blunt.
        );

        return $this->created($department->getKey());
    }

    public function update(Request $request, $department) {
        $department = repository(Department::class)->find($department);
        $this->authorize($department);

        repository(Department::class)->update($department, $request->all());

        return $this->accepted();
    }

    public function getPeopleCount(Request $request) {
        $departments = repository(Department::class)->with('head')->all();

        $students = DB::table('students')
                      ->where('school_id', $request->user()->school_id)
                      ->groupBy('department_id')
                      ->select([DB::raw('count(*) as aggregate'), 'department_id'])
                      ->get()->pluck('aggregate', 'department_id');

        $teachers = DB::table('teachers')
                      ->groupBy('department_id')
                      ->select([DB::raw('count(*) as aggregate'), 'department_id'])
                      ->get()->pluck('aggregate', 'department_id');
        $employees = DB::table('employees')
                       ->groupBy('department_id')
                       ->select([DB::raw('count(*) as aggregate'), 'department_id'])
                       ->get()->pluck('aggregate', 'department_id');

        foreach ($departments as $department) {
            $department->student_count = $students->get($department->getKey(), 0);
            $department->teacher_count = $teachers->get($department->getKey(), 0);
            $department->employee_count = $employees->get($department->getKey(), 0);
        }

        return $departments;
    }
}
