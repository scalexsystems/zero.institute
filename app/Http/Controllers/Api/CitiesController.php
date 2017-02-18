<?php namespace Scalex\Zero\Http\Controllers\Api;

use Illuminate\Http\Request;
use Scalex\Zero\Criteria\ExactMatch;
use Scalex\Zero\Criteria\OrderBy;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Http\Requests;
use Scalex\Zero\Models\City;
use Scalex\Zero\Repositories\CityRepository;

class CitiesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api,web');
    }

    /**
     * List all cities (paginated).

*
*@param \Illuminate\Http\Request $request
     * @param \Scalex\Zero\Repositories\CityRepository $repository


*
*@return \Illuminate\Contracts\Pagination\Paginator
     */
    public function index(Request $request, CityRepository $repository)
    {
        if ($request->has('q')) {
            $repository->search($request->query('q'));
        } else {
            $repository->pushCriteria(new OrderBy('name'));
        }

        return $repository->simplePaginate();
    }

    /**
     * Get a city by ID.

*
*@param \Illuminate\Http\Request $request
     * @param \Scalex\Zero\Models\City $city
     *
*@return \Scalex\Zero\Models\City
     */
    public function show(Request $request, City $city)
    {
        return $city;
    }
}
