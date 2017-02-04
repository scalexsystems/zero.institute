<?php

namespace Scalex\Zero\Providers;

use Illuminate\Support\AggregateServiceProvider;

class DevelopmentServiceProvider extends AggregateServiceProvider
{
    protected $providers = [
        '\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider',
        '\Themsaid\MailPreview\MailPreviewServiceProvider',
        '\Mmieluch\LaravelVfsProvider\LaravelVfsServiceProvider',
    ];

    public function register()
    {
        // Don't load in production env.
        if (!hash_equals('production', $this->app->environment())) {
            parent::register();
        }
    }
}
