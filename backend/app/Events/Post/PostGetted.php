<?php

namespace App\Events\Post;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PostGetted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public array $posts;
    public string $title = 'Посты получены!';

    /**
     * Create a new event instance.
     */
    public function __construct(array $posts)
    {
        $this->posts = $posts;

        logger('123');
    }

    public function broadcastOn(): Channel
    {
        return new Channel('App.Events.Post.all');
    }
//    public function broadcastAs(): string
//    {
//            return 'PostGetted';
//    }
    public function broadcastWith(): array
    {
        return ['title' => $this->title];
    }
}
