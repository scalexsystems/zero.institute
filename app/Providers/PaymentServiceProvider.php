<?php

namespace Scalex\Zero\Providers;

use Illuminate\Support\ServiceProvider;
use Omnipay\Common\GatewayFactory;
use Scalex\Zero\Managers\OmnipayManager;

class PaymentServiceProvider extends ServiceProvider
{
    protected $defer = true;

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('omnipay', function ($app) {
            return new OmnipayManager($app, new GatewayFactory());
        });
    }

    public function provides()
    {
        return ['omnipay'];
    }
}
