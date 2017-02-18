<?php namespace Scalex\Zero\Providers;

use Znck\Trust\TrustServiceProvider as OriginalTrustServiceProvider;
use Scalex\Zero\Models;

class TrustServiceProvider extends OriginalTrustServiceProvider
{
    protected $models = [
        // People Related.
        [Models\Student::class, ['invite']],
        [Models\Teacher::class, ['invite']],
        [Models\Employee::class, ['invite']],

        [Models\School::class, []],
        Models\Course::class,

        // School Related.
        Models\Session::class,
        Models\Department::class,
        Models\Discipline::class,
        Models\Semester::class,
    ];

    protected $permissions = [
        // People
        'people.app' => 'Access people & statistics',
        'people.statistics' => 'View people statistics',

        // Courses
        'course.app' => 'Access course management',

        // Settings
        'settings.app' => 'Access school settings',
    ];

    protected $roles = [
        'admin' => [
            'name' => 'Administrator',
            'permissions' => ['*'],
        ],
        'course-manager' => [
            'name' => 'Course Manager',
            'permissions' => ['course.*'],
        ],
    ];
}
