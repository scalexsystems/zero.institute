<?php namespace Scalex\Zero\Providers;

use Znck\Trust\TrustServiceProvider as OriginalTrustServiceProvider;
use Scalex\Zero\Models;

class TrustServiceProvider extends OriginalTrustServiceProvider
{
    protected $models = [
        [Models\Student::class, ['invite']],
        [Models\Teacher::class, ['invite']],
        [Models\Employee::class, ['invite']],
        [Models\School::class, []],
        Models\Course::class,
    ];

    protected $permissions = [
        'people.statistics' => [
            'name' => 'View People Statistics',
        ],
    ];

    protected $roles = [
        'admin' => [
            'name' => 'Administrator',
            'description' => 'These users would have every available permission.',
            'permissions' => ['*'],
        ],
        'course-manager' => [
            'name' => 'Course Manager',
            'description' => 'add courses and assign teachers/coordinator',
            'permissions' => ['course.*'],
        ],
    ];
}
