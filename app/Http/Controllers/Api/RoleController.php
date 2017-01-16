<?php

namespace Scalex\Zero\Http\Controllers\Api;

use Illuminate\Http\Request;
use Scalex\Zero\Criteria\OrderBy;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\User;
use Scalex\Zero\Models\Role;

class RoleController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api,web');
    }

    public function index(Request $request, $role) {
        $this->authorize('isAdmin', $request->user());

        if (!$role->exists) {
            return abort(404, "No role name ${role} exists");
        }

        return $role
            ->users()
            ->wherePivot('school_id', $request->user()->school_id)
            ->with('person')
            ->get()
            ->map(function ($user) {
                return $user->person;
            });
    }

    public function store(Request $request) {
        $this->authorize('isAdmin', $request->user());
        $this->validate($request, [
            'role' => 'required|exists:roles,slug',
            'managers.*.type' => 'required|in:student,teacher,employee',
            'managers.*.id' => 'required|integer',
        ]);

        $role = Role::whereSlug($request->input('role'))->first();
        $users = (array) $request->input('managers', []);

        repository(Role::class)->assign($role, $request->user()->school, $users);

        return $this->created();
    }
}
