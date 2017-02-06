<?php namespace Scalex\Zero\Http\Controllers\Api\People;

use Illuminate\Http\Request;
use Scalex\Zero\Criteria\FilterIntents;
use Scalex\Zero\Criteria\OfSchool;
use Scalex\Zero\Criteria\OrderBy;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Http\Requests;
use Scalex\Zero\Models\Employee;
use Scalex\Zero\Models\Intent;
use Scalex\Zero\Models\Student;
use Scalex\Zero\Models\Teacher;
use Scalex\Zero\Repositories\UserRepository;
use Scalex\Zero\User;
use Znck\Trust\Models\Role;

class PersonFinderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api,web');
    }

    public function index(Request $request, UserRepository $repository)
    {
        $request->query->set('with', 'person');

        $repository->with(['photo', 'person', 'person.photo'])
                   ->pushCriteria(new OfSchool($request->user()->school));

        if ($request->has('q')) {
            $repository->search($request->input('q'));
        } else {
            $repository->pushCriteria(new OrderBy('name'));
        }

        return $repository->paginate();
    }

    public function show(Request $request, UserRepository $repository, $person)
    {
        $request->query->set('with', 'person');
        $user = repository(User::class)
            ->with(['person', 'profilePhoto', 'person.profilePhoto'])
            ->pushCriteria(new OfSchool($request->user()->school))
            ->find((int)$person);

        return $user;
    }
}
