<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Post\PostCommentRequest;
use App\Http\Requests\Api\Post\PostIndexRequest;
use App\Http\Requests\Api\Post\PostLikeRequest;
use App\Http\Requests\Api\Post\PostStoreRequest;
use App\Models\Post;
use App\Services\Api\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(PostIndexRequest $request)
    {
        $inputs = $request->validated();
        $service = new PostService();
        $posts = $service->index($inputs);
        return response()->json($posts);
    }

    public function store(PostStoreRequest $request)
    {
        $inputs = $request->validated();
        $service = new PostService();
        $post = $service->store($inputs);
        return response()->json($post);
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        $post = $post
            ->where('id', $id)
            ->withCount(['likes'])
            ->with('tags', 'comments')
            ->first();
        return response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function like(PostLikeRequest $request)
    {
        $input = $request->all();
        $service = new PostService();
        $liked = $service->isLikedPost($input);
        return response()->json($liked);
    }

    public function comment(PostCommentRequest $request)
    {
        $input = $request->all();
        $service = new PostService();
        $post = $service->comment($input);
        return response()->json($post);
    }
}
