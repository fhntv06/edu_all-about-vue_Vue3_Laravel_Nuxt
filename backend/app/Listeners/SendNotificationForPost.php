<?php

namespace App\Listeners;

use App\Events\Post\PostGetted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNotificationForPost implements ShouldQueue
{
    use InteractsWithQueue;
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
    public function handle(PostGetted $event): void
    {
        logger('Уведомление: получены посты!');
        logger([
            'data' => $event->posts
        ]);
    }
}
