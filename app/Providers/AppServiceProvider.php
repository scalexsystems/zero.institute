<?php

namespace Scalex\Zero\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        $this->loadTranslationsFrom(resource_path('lang-web'), 'app');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }
}
