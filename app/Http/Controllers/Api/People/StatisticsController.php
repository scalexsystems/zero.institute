<?php namespace Scalex\Zero\Http\Controllers\Api\People;

use Scalex\Zero\Http\Controllers\Controller;

class StatisticsController extends Controller
{
    public function stats()
    {
        // FIXME: Check permission here!
        // FIXME: Move to other controller.

        return [
            'requests' => cache()->rememberForever(schoolScopeCacheKey('stats.accounts'), function () {
                $q = ['tag' => 'account', 'locked' => true];

                return [
                    'student' => repository(Intent::class)->pushCriteria(new FilterIntents($q + ['type' => 'student']))->count(),
                    'teacher' => repository(Intent::class)->pushCriteria(new FilterIntents($q + ['type' => 'teacher']))->count(),
                    'employee' => repository(Intent::class)->pushCriteria(new FilterIntents($q + ['type' => 'employee']))->count(),
                ];
            }),
            'incomplete' => cache()->rememberForever(schoolScopeCacheKey('stats.incomplete'), function () {
                $q = ['tag' => 'account', 'locked' => false];

                return repository(Intent::class)->pushCriteria(new FilterIntents($q))->count();
            }),
            'accounts' => cache()->rememberForever(schoolScopeCacheKey('stats.people'), function () {
                return [
                    'student' => repository(Student::class)->count(),
                    'teacher' => repository(Teacher::class)->count(),
                    'employee' => repository(Employee::class)->count(),
                ];
            }),
        ];
    }
}
