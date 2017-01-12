<?php

namespace Scalex\Zero\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use Scalex\Zero\Models;
use Scalex\Zero\Policies;
use Scalex\Zero\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => Policies\UserPolicy::class,
        /** School */
        Models\School::class => Policies\SchoolPolicy::class,
        Models\Discipline::class => Policies\DisciplinePolicy::class,
        Models\Department::class => Policies\DepartmentPolicy::class,
        Models\Semester::class => Policies\SemesterPolicy::class,
        /** People */
        Models\Student::class => Policies\StudentPolicy::class,
        Models\Teacher::class => Policies\TeacherPolicy::class,
        Models\Employee::class => Policies\EmployeePolicy::class,
        /** Others */
        Models\Intent::class => Policies\IntentPolicy::class,
        Models\Group::class => Policies\GroupPolicy::class,
        Models\Message::class => Policies\MessagePolicy::class,
        /** Course */
        Models\Course::class => Policies\CoursePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot() {
        $this->registerPolicies();

        Passport::routes();
        Passport::pruneRevokedTokens();
    }
}
