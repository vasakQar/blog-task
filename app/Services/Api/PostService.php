<?php

namespace App\Services\Api;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PostService
{
    public function store($inputs)
    {
        $user = Auth::user();
        $post = $user->posts()->create($inputs);
        $post->tags()->attach($inputs['tag_ids']);
        return $post;
    }
}
