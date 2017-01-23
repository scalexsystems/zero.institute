<?php namespace Scalex\Zero\Http\Controllers\Api\Users;

use Scalex\Zero\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api,web');
    }

    public function index()
    {
        return [
            'apps' => [],
        ];
    }
}
