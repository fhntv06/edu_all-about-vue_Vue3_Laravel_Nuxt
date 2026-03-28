<?php

namespace App\Listeners;

use App\Events\User\UserCreated;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNotificaionForUserCreated implements ShouldQueue
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
    public function handle(UserCreated $event): void
    {
        logger('Пользователь был создан!');
        logger($event->user);
    }
}
