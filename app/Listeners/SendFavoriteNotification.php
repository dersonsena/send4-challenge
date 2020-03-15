<?php

namespace App\Listeners;

use App\Events\SendFavoriteNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ExampleListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\SendFavoriteNotification  $event
     * @return void
     */
    public function handle(SendFavoriteNotification $event)
    {
        //
    }
}
