<?php

namespace Scalex\Zero\Http\Controllers\Api;

use Illuminate\Http\Request;
use Scalex\Zero\Criteria\OrderBy;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\User;
use Znck\Trust\Models\Role;

class RoleController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api,web');
    }

    /**
     * Get list of users with a role in school.
     * GET /people
     * Require: auth
     */
    public function index(Request $request, Role $role) {
        return $role->users ?? [];
//        if ($request->has('id')) {
//            return $users->findMany([$request->input('id')]);
//        } elseif ($request->has('q')) {
//            $users->search($request->input('q'));
//        } else {
//            $users->pushCriteria(new OrderBy('name'));
//        }
//        return $users->paginate();
    }

    public function store(Request $request, Role $role) {
        $this->authorize('store', $role);

        $members = $request->get('managers');
        repository('Role')->assign($members, $role);

        return $this->created();
    }
}
