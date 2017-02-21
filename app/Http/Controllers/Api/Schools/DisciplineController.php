<?php namespace Scalex\Zero\Http\Controllers\Api\Schools;

use DB;
use Illuminate\Http\Request;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\Discipline;

class DisciplineController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api,web');
    }

    public function index(Request $request)
    {
        return repository(Discipline::class)->withCount('students')->all();
    }

    public function store(Request $request)
    {
        $this->authorize('store', Discipline::class);

        $discipline = repository(Discipline::class)->create(
            [
                'school' => \Auth::user()->school,
                'school_id' => \Auth::user()->school_id,
            ] + $request->all()
        );

        return $discipline;
    }

    public function update(Request $request, $discipline)
    {
        $discipline = repository(Discipline::class)->withCount('students')->find($discipline);
        $this->authorize($discipline);

        repository(Discipline::class)->update($discipline, $request->all());

        return $discipline;
    }
}
