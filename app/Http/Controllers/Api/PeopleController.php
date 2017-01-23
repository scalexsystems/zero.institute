<?php namespace Scalex\Zero\Http\Controllers\Api;

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
use Scalex\Zero\User;
use Znck\Trust\Models\Role;

class PeopleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api,web');
    }

    /**
     * Get list of users in school.
     * GET /people
     * Require: auth
     */
    public function index(Request $request)
    {
        $request->query->set('with', 'person');

        $users = repository(User::class)
            ->with(['person', 'profilePhoto', 'person.profilePhoto'])
            ->pushCriteria(new OfSchool($request->user()->school)); // Limiting user search to school only!

        if ($request->has('id')) {
            return $users->findMany([$request->input('id')]);
        } elseif ($request->has('q')) {
            $users->search($request->input('q'));
        } else {
            $users->pushCriteria(new OrderBy('name'));
        }

        return $users->paginate();
    }

    public function show(Request $request, $person)
    {
        $request->query->set('with', 'person');
        $user = repository(User::class)
            ->with(['person', 'profilePhoto', 'person.profilePhoto'])
            ->pushCriteria(new OfSchool($request->user()->school))
            ->find((int)$person);

        return $user;
    }

    /**
     * Get people statistics.
     * GET /people/stats
     * Require: auth, permission:school-stats
     */
    public function stats()
    {
        // FIXME: Check permission here!
        // FIXME: Move to other controller.

        return [
            'requests' => cache()->rememberForever(schoolify('stats.accounts'), function () {
                $q = ['tag' => 'account', 'locked' => true];

                return [
                    'student' => repository(Intent::class)->pushCriteria(new FilterIntents($q + ['type' => 'student']))->count(),
                    'teacher' => repository(Intent::class)->pushCriteria(new FilterIntents($q + ['type' => 'teacher']))->count(),
                    'employee' => repository(Intent::class)->pushCriteria(new FilterIntents($q + ['type' => 'employee']))->count(),
                ];
            }),
            'incomplete' => cache()->rememberForever(schoolify('stats.incomplete'), function () {
                $q = ['tag' => 'account', 'locked' => false];

                return repository(Intent::class)->pushCriteria(new FilterIntents($q))->count();
            }),
            'accounts' => cache()->rememberForever(schoolify('stats.people'), function () {
                return [
                    'student' => repository(Student::class)->count(),
                    'teacher' => repository(Teacher::class)->count(),
                    'employee' => repository(Employee::class)->count(),
                ];
            }),
        ];
    }
}
