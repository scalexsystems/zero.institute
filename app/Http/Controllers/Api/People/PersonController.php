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

class PersonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api,web');
    }

    public function index(Request $request, UserRepository $repository)
    {
        $request->query->set('with', 'person');

        $repository->with(['person', 'person.photo'])
                   ->pushCriteria(new OfSchool($request->user()->school));

        if ($request->has('q')) {
            $repository->search($request->input('q'));
        } else {
            $repository->pushCriteria(new OrderBy('name'));
        }

        $results = $repository->paginate();
        $people = $results->getCollection()->map(function ($user) {
            return transformer($user->person)->setIndexing()->transform($user->person);
        });
        $results->setCollection($people);

        return $results;
    }

    public function show(Request $request, User $user)
    {
        return [
            'item' => transformer($user->person)->setIndexing()->transform($user),
        ];
    }
}
