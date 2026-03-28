<?php

namespace App\Events\Post;

use App\Models\Post;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PostUpdated implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public Post $post;

    /**
     * Создать новый экземпляр события.
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }
    public function broadcastOn(): Channel
    {
         return new PrivateChannel('App.Models.Posts.'.$this->post->id);
    }
    public function broadcastAs(): string
    {
        return 'PostUpdated';
    }
}
