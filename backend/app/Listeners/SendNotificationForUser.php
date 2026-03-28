<?php

namespace App\Listeners;

use App\Events\User\UserCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNotificationForUser implements ShouldQueue
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
    public function handle(UserCreated $event): void
    {
        logger('Уведомление пользователя с id='.$event->user->id);
        logger([
            'user' => $event->user
        ]);
    }
}
