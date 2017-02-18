<?php namespace Scalex\Zero\Http\Controllers\Api\Schools;

use DB;
use Illuminate\Http\Request;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\Department;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api,web');
    }

    public function index(Request $request)
    {
        return cache()->rememberForever(
            schoolScopeCacheKey('departments'),
            function () use ($request) {
                return repository(Department::class)->with('head')->withCount([
                    'students',
                    'teachers',
                    'employees',
                ])->all();
            }
        );
    }

    public function store(Request $request)
    {
        $this->authorize('store', Department::class);

        $department = repository(Department::class)->createForSchool(
            $request->user()->school,
            $request->all()
        );

        return $this->reFetchDepartment($department);
    }

    public function update(Request $request, $department)
    {
        $department = repository(Department::class)->find($department);
        $this->authorize($department);

        repository(Department::class)->update($department, $request->all());

        return $this->reFetchDepartment($department);
    }

    protected function reFetchDepartment(Department $department)
    {
        return Department::with('head')->withCount([
            'students',
            'teachers',
            'employees',
        ])->find($department->getKey());
    }
}
