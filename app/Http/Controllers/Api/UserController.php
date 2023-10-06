<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\UserRequest;
use App\Services\Api\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function edit(UserRequest $request)
    {
        $inputs = $request->validated();
        $service = new UserService();
        $user = $service->edit($inputs);
        return response()->json([
            'message' => 'User has been updated successfully!',
        ], 200);
    }

    public function delete(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();
        $user->delete();
        return response()->json([
            'message' => 'User has been deleted successfully!'
        ], 200);
    }
}
