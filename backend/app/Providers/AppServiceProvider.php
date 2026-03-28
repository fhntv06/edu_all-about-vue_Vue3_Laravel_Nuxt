<?php

namespace App\Providers;

use App\Events\Post\PostCreated;
use App\Events\Post\PostGetted;
use App\Events\Post\PostUpdated;
use App\Events\User\UserCreated;
use App\Listeners\SendNotificaionForPostCreated;
use App\Listeners\SendNotificaionForPostUpdated;
use App\Listeners\SendNotificaionForUserCreated;
use App\Listeners\SendNotificationForPost;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $registers = [
        PostGetted::class => SendNotificationForPost::class,
        PostCreated::class => SendNotificaionForPostCreated::class,
        PostUpdated::class => SendNotificaionForPostUpdated::class,
        UserCreated::class => SendNotificaionForUserCreated::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerEventsAndListeners();
    }

    private function registerEventsAndListeners(): void
    {
        foreach ($this->registers as $event => $listener) {
            Event::listen($event, $listener);
        }
    }
}
