<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\User;
use App\Models\Post;

Broadcast::channel('App.Events.User.{userId}', function (User $user, $userId) {
    return true;
});
Broadcast::channel('App.Events.Post.all', function (Post $post) {
    return true;
});
Broadcast::channel('App.Events.Posts.{id}', function (User $user, int $postId) {
    return $user->id === Post::find($postId)->user_id;
});
