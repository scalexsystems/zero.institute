<?php

namespace Scalex\Zero\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Scalex\Zero\Events;
use Scalex\Zero\Listeners;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Events\InvitationRequest::class => [
            Listeners\Invitation\SendInvitationVerification::class,
            Listeners\Invitation\ReportNewInvitationRequest::class,
        ],
    ];


    protected $subscribe = [
        Listeners\UserEventSubscriber::class,
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
