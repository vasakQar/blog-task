<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Tag\TagStoreRequest;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::all();
        return response()->json($tags);
    }

    public function store(TagStoreRequest $request)
    {
        $inputs = $request->validated();
        Tag::firstOrCreate(['name' => $inputs['name']]);
        return response()->json([
            'message' => 'Tag created successfully!'
        ], 200);
    }
}
