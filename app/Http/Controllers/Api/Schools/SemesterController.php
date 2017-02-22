<?php namespace Scalex\Zero\Http\Controllers\Api\Schools;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\Semester;

class SemesterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api,web');
    }

    public function index(Request $request)
    {
        return repository(Semester::class)->all();
    }

    public function store(Request $request)
    {
        $this->authorize('store', Semester::class);

        $semester = repository(Semester::class)->create(
            [
                'school' => $request->user()->school,
                'school_id' => $request->user()->school_id,
            ] + $request->all()
        );

        return $semester;
    }

    public function update(Request $request, $semester)
    {
        $semester = repository(Semester::class)->find($semester);
        $this->authorize($semester);

        repository(Semester::class)->update($semester, $request->all());

        return $semester;
    }
}
