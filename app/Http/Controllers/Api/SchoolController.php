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
            ->search($request->query('q', ''))
            ->where('verified', true)
            ->paginate();

        return $schools;
    }

    /*
     * Get school of authenticated user.
     *
     * GET /school
     *
     * Requires: auth
     */
    public function show() {
        return $this->user()->school;
    }

    /*
     * Update school information.
     *
     * PUT /school
     *
     * Requires: auth
     */
    public function update(Request $request) {
        $school = $this->user()->school;

        repository(School::class)->update($request->input(), $school);

        return $this->accepted();
    }
}
