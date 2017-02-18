<?php namespace Scalex\Zero\Http\Controllers\Api\People;

use Illuminate\Http\Request;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Services\PeopleStatisticsService;

class StatisticsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api,web');
    }

    public function index(Request $request)
    {
        $this->authorize('view-people-statistics', $request->user()->school);

        $stats = new PeopleStatisticsService($request->user()->school_id);

        return [
            'student' => $stats->student(),
            'teacher' => $stats->teacher(),
            'employee' => $stats->employee(),
        ];
    }
}
