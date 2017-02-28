<?php

namespace Scalex\Zero\Providers;

use Illuminate\Support\AggregateServiceProvider;

class DevelopmentServiceProvider extends AggregateServiceProvider
{
    protected $providers = [
        \TeamTNT\Scout\TNTSearchScoutServiceProvider::class,
        \Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class,
        \Themsaid\MailPreview\MailPreviewServiceProvider::class,
        \Mmieluch\LaravelVfsProvider\LaravelVfsServiceProvider::class,
        \Laravel\Tinker\TinkerServiceProvider::class,
    ];

    public function register()
    {
        // Don't load in production env.
        if (!hash_equals('production', $this->app->environment())) {
            parent::register();
        }
    }
}
