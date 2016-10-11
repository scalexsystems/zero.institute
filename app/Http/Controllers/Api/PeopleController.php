<?php namespace Scalex\Zero\Http\Controllers\Api;

use Scalex\Zero\Criteria\FilterIntents;
use Scalex\Zero\Http\Controllers\Controller;
use Scalex\Zero\Http\Requests;
use Scalex\Zero\Models\Employee;
use Scalex\Zero\Models\Intent;
use Scalex\Zero\Models\Student;
use Scalex\Zero\Models\Teacher;

class PeopleController extends Controller
{
    public function stats() {
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
