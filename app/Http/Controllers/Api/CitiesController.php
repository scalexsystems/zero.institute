<?php namespace Scalex\Zero\Http\Controllers\Api;

use Illuminate\Http\Request;
use Scalex\Zero\Criteria\ExactMatch;
use Scalex\Zero\Criteria\OrderBy;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Http\Requests;
use Scalex\Zero\Models\Geo\City;

class CitiesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api,web');
    }

    public function index(Request $request)
    {
        $cities = repository(City::class);

        if ($request->has('q')) {
            $q = $request->query('q');

            if (is_numeric($q)) {
                $cities->pushCriteria(new ExactMatch($q));
            } else {
                $cities->search($q);
            }
        } else {
            $cities->pushCriteria(new OrderBy('name'));
        }

        return $cities->simplePaginate();
    }
}
