<?php

namespace App\Providers;

use App\Events\NotifyFavoriteEvent;
use App\Listeners\ExampleListener;
use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        NotifyFavoriteEvent::class => [
            ExampleListener::class,
        ],
    ];
}
