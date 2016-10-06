<?php

namespace Scalex\Zero\Http\Controllers\Api;

use Illuminate\Http\Request;
use Scalex\Zero\Criteria\ExactMatch;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Http\Requests;
use Scalex\Zero\Models\Geo\City;

class GeoController extends Controller
{
    public function cities(Request $request) {
        $q = $request->query('q', '');

        $cites = repository(City::class)
            ->pushCriteria(new ExactMatch($q))
            ->search($q)
            ->paginate();

        return $cites;
    }
}
