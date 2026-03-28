<?php

namespace App\Listeners;

use App\Events\Post\PostUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNotificaionForPostUpdated implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PostUpdated $event): void
    {
        logger('Пост был создан!');
        logger($event->post);
    }
}
