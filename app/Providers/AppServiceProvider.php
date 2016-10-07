<?php

namespace Scalex\Zero\Providers;

use App;
use DB;
use Event;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Log;
use Scalex\Zero\Models;
use Znck\Transformers\Serializers\EmbedSerializer;
use Znck\Transformers\Transformer;

class AppServiceProvider extends ServiceProvider
{
    protected $logs = [];
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        $this->loadTranslationsFrom(resource_path('lang-web'), 'app');
        Transformer::getManager()->setSerializer(new EmbedSerializer());
        DB::listen(function ($query) {
            $this->logs[] = [
                'sql' => $query->sql,
                'bindings' => $query->bindings,
                'time' => $query->time,
            ];
        });
        Event::listen('kernel.handled', function () {
            Log::info('DB QUERIES', $this->logs);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        Relation::morphMap([
            'user' => User::class,
            'school' => Models\School::class,
            'attachment' => Models\Attachment::class,
            'address' => Models\Geo\Address::class,
            'country' => Models\Geo\Country::class,
            'state' => Models\Geo\State::class,
            'city' => Models\Geo\City::class,
            // 'request' => Models\Request::class,
        ]);
    }
}
