<?php

namespace Scalex\Zero\Providers;

use DB;
use Event;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Log;
use Scalex\Zero\Models;
use Scalex\Zero\Observers;
use Scalex\Zero\User;
use Znck\Attach\AttachServiceProvider;
use Znck\Transformers\Serializers\EmbedSerializer;
use Znck\Transformers\Transformer;

class AppServiceProvider extends ServiceProvider
{
    protected $logs = [];

    public function __construct($app) {
        parent::__construct($app);
        AttachServiceProvider::$runMigrations = false;
    }


    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        $this->loadTranslationsFrom(resource_path('lang-web'), 'app');

        $this->registerApiSerializer();
        $this->registerQueryLogger();
        $this->registerObservers();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        $this->registerRelationMap();
    }

    protected function registerQueryLogger() {
        DB::listen(function ($query) {
            $this->logs[] = [
                'sql' => $query->sql,
                'bindings' => $query->bindings,
                'time' => $query->time,
            ];
        });
        Event::listen('kernel.handled', function () {
            if (config('app.debug')) {
                foreach ($this->logs as $log) {
                     // Log::debug('DB QUERY', $log);
                }
            } else {
                Log::info('DB QUERIES', $this->logs);
            }
        });
    }

    protected function registerApiSerializer() {
        Transformer::getManager()->setSerializer(new EmbedSerializer());
    }

    protected function registerObservers() {
        if (\App::runningInConsole()) {
            return;
        }

        User::observe(Observers\UserObserver::class);

        /**
         * School
         */
        Models\School::observe(Observers\SchoolObserver::class);
        Models\Discipline::observe(Observers\DisciplineObserver::class);
        Models\Department::observe(Observers\DepartmentObserver::class);

        /**
         * People
         */
        Models\Student::observe(Observers\StudentObserver::class);
        Models\Employee::observe(Observers\EmployeeObserver::class);
        Models\Teacher::observe(Observers\TeacherObserver::class);
    }

    protected function registerRelationMap() {
        Relation::morphMap(
            [
                'user' => User::class,
                /**
                 * School
                 */
                'school' => Models\School::class,
                'department' => Models\Department::class,
                'discipline' => Models\Discipline::class,
                /**
                 * People
                 */
                'student' => Models\Student::class,
                'teacher' => Models\Teacher::class,
                'employee' => Models\Employee::class,
                'guardian' => Models\Guardian::class,
                /**
                 * Others
                 */
                'attachment' => Models\Attachment::class,
                'address' => Models\Geo\Address::class,
                'country' => Models\Geo\Country::class,
                'state' => Models\Geo\State::class,
                'city' => Models\Geo\City::class,
                'intent' => Models\Intent::class,
                /**
                 * Communication
                 */
                'group' => Models\Group::class,
                'message' => Models\Message::class,
            ]
        );
    }
}
