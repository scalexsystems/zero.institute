<?php namespace Scalex\Zero\Http\Controllers\Api\Schools;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\Semester;

class SemesterController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api,web');
    }

    public function index(Request $request) {
        return cache()->rememberForever(
            schoolify('semesters'),
            function () use ($request) {
                return $this->getPeopleCount($request);
            }
        );
    }

    public function store(Request $request) {
        $this->authorize('store', Semester::class);

        $semester = repository(Semester::class)->create(
            [
                'school' => current_user()->school,
                'school_id' => current_user()->school_id,
            ] + $request->all()
        );

        return $this->created($semester->getKey());
    }

    public function update(Request $request, $semester) {
        $semester = repository(Semester::class)->find($semester);
        $this->authorize($semester);

        repository(Semester::class)->update($semester, $request->all());

        return $this->accepted();
    }

    public function getPeopleCount(Request $request) {
        $disciplines = repository(Semester::class)->all();

        $students = DB::table('students')
            ->where('school_id', $request->user()->school_id)
            ->groupBy('discipline_id')
            ->select([DB::raw('count(*) as aggregate'), 'discipline_id'])
            ->get()->pluck('aggregate', 'discipline_id');
        //FIXME::

        foreach ($disciplines as $discipline) {
            $discipline->student_count = $students->get($discipline->getKey(), 0);
        }

        return $disciplines;
    }
}
