<?php

namespace App\Services\Api;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostService
{
    public function store($inputs)
    {
        $user = Auth::user();
        $post = $user->posts()->create($inputs);
        $post->tags()->attach($inputs['tag_ids']);
        return $post;
    }

    public function isLikedPost($input)
    {
        $userId = Auth::id();
        $postId = $input['id'];
        $post = Post::find($postId);
        $existingLike = $post->likes()->where('user_id', $userId)->first();
        if ($existingLike) {
            $existingLike->delete();
            return [
                'liked' => false,
                'likes_count' => $post->likes()->count()
            ];
        } else {
            $post->likes()->create(['user_id' => $userId]);
            return [
                'liked' => true,
                'likes_count' => $post->likes()->count()
            ];
        }
    }

    public function comment($input)
    {
        $postId = $input['id'];
        $userId = Auth::id();

        $post = Post::find($postId);
        $post->comments()->create([
            'user_id' => $userId,
            'title' => $input['title'],
            'content' => $input['content']
        ]);

        $post = $post->query()
            ->withCount(['likes'])
            ->selectRaw(
                "posts.*,
                (SELECT COUNT(*) FROM post_likes WHERE post_likes.post_id = posts.id AND post_likes.user_id = ?) > 0 AS liked"
            )
            ->addBinding($userId, 'select')
            ->with('tags', 'comments')
            ->first();
        return $post;
    }
}
