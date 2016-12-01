<?php namespace Scalex\Zero\Http\Controllers\Api\Schools;

use Illuminate\Http\Request;
use Scalex\Zero\Http\Controllers\Controller;

class CurrentSchoolController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api,web');
    }

    /*
     * Get school of authenticated user.
     *
     * GET /school
     *
     * Requires: auth
     */
    public function index(Request $request) {
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
