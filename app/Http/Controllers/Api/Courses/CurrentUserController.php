<?php

namespace Scalex\Zero\Http\Controllers\Api\Courses;

use Illuminate\Http\Request;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\Student;
use Scalex\Zero\Models\Teacher;

class CurrentUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api,web');
    }

    public function sessions(Request $request)
    {
        $person = $request->user()->person;

        if ($person instanceof Student or $person instanceof Teacher)
        {
            return transform($person->sessions, [], null, true);
        }

        return collect([]);
    }
}
