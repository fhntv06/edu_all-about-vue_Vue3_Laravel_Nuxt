<?php

namespace App\Listeners;

use App\Events\Post\PostCreated;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNotificaionForPostCreated implements ShouldQueue
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
    public function handle(PostCreated $event): void
    {
        logger('Пост был создан!');
        logger($event->post);
    }
}
