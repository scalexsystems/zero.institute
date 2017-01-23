<?php namespace Scalex\Zero\Http\Controllers\Api\Schools;

use Illuminate\Http\Request;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\School;

class SchoolController extends Controller
{
    /*
     * Get list of schools.
     *
     * GET /schools
     */
    public function index(Request $request)
    {
        $schools = repository(School::class)
            ->with(['address', 'logo'])
            ->pushCriteria(
                criteria(function ($query) {
                    /** @var \Illuminate\Database\Query\Builder $query */
                    $query->where('verified', true);
                }));

        if ($request->has('q')) {
            $schools->search($request->query('q'));
        }

        return $schools->paginate();
    }
}
