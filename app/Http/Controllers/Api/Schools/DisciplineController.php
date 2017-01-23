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
        return cache()->rememberForever(
            schoolify('disciplines'),
            function () use ($request) {
                return $this->getPeopleCount($request);
            }
        );
    }

    public function store(Request $request)
    {
        $this->authorize('store', Discipline::class);

        $discipline = repository(Discipline::class)->create(
            [
                'school' => current_user()->school,
                'school_id' => current_user()->school_id,
            ] + $request->all()
        );

        return $this->created($discipline->getKey());
    }

    public function update(Request $request, $discipline)
    {
        $discipline = repository(Discipline::class)->find($discipline);
        $this->authorize($discipline);

        repository(Discipline::class)->update($discipline, $request->all());

        return $this->accepted();
    }

    public function getPeopleCount(Request $request)
    {
        $disciplines = repository(Discipline::class)->all();

        $students = DB::table('students')
                      ->where('school_id', $request->user()->school_id)
                      ->groupBy('discipline_id')
                      ->select([DB::raw('count(*) as aggregate'), 'discipline_id'])
                      ->get()->pluck('aggregate', 'discipline_id');

        foreach ($disciplines as $discipline) {
            $discipline->student_count = $students->get($discipline->getKey(), 0);
        }

        return $disciplines;
    }
}
