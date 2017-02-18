<?php

namespace Scalex\Zero\Http\Controllers\Api\Schools;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Models\Role;
use Scalex\Zero\Repositories\RoleRepository;
use Scalex\Zero\User;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api,web');
    }

    public function index(Request $request)
    {
        $this->authorize('view', Role::class);

        return Role::all();
    }


    public function users(Request $request, RoleRepository $repository, Role $role)
    {
        $this->authorize('view', Role::class);

        return [
            'items' => $repository->users($role, $request->user()->school)->map(function (User $user) {
                return transformer($user->person)->setIndexing(false)->transform($user->person);
            }),
        ];
    }

    public function assign(Request $request, Role $role)
    {
        $this->authorize('update', Role::class);
        $this->validate($request, [
            'user_id' => [
                'bail',
                'required',
                Rule::exists('users', 'id')->where('school_id', $request->user()->school_id),
            ],
        ]);

        $user = User::find($request->input('user_id'));

        $user->assignRole($role);

        $this->accepted();
    }

    public function revoke(Request $request, Role $role)
    {
        $this->authorize('update', Role::class);
        $this->validate($request, [
            'user_id' => [
                'bail',
                'required',
                Rule::exists('users', 'id')->where('school_id', $request->user()->school_id),
            ],
        ]);

        $user = User::find($request->input('user_id'));

        if ($role->slug === 'admin' and $user->getKey() === $request->user()->getKey()) {
            abort(400, 'You cannot remove yourself.');
        }

        $user->revokeRole($role);

        $this->accepted();
    }
}
