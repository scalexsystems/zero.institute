<?php namespace Scalex\Zero\Http\Controllers\Api;

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
    public function index(Request $request) {
        $schools = repository(School::class)
            ->with(['address', 'logo'])
            ->pushCriteria(
                criteria(
                    function ($query) {
                        $query->where('verified', true);
                    }
                )
            );

        if ($request->has('q')) {
            $schools->search($request->query('q'));
        }

        return $schools->paginate();
    }

    /*
     * Get school of authenticated user.
     *
     * GET /school
     *
     * Requires: auth
     */
    public function show(Request $request) {
        $request->query->add(['with' => 'address']);

        return $request->user()->school;
    }

    /*
     * Update school information.
     *
     * PUT /school
     *
     * Requires: auth
     */
    public function update(Request $request) {
        $school = $request->user()->school;

        $this->authorize($school);

        repository(School::class)->update($school, $request->all());

        return $this->accepted();
    }
}
