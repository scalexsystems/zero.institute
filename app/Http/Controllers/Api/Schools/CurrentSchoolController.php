<?php namespace Scalex\Zero\Http\Controllers\Api\Schools;

use Illuminate\Http\Request;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\School;

class CurrentSchoolController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api,web');
    }

    /*
     * Get school of authenticated user.
     *
     * GET /school
     *
     * Requires: auth
     */
    public function index(Request $request)
    {
        return transform($request->user()->school, ['address'], null, true);
    }

    /*
     * Update school information.
     *
     * PUT /school
     *
     * Requires: auth
     */
    public function update(Request $request)
    {
        $school = $request->user()->school;

        $this->authorize('update', $school);

        repository(School::class)->update($school, $request->all());

        return $this->accepted();
    }
}
