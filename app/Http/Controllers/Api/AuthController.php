<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\UserRequest;
use App\Services\Api\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(UserRequest $request)
    {
        $inputs = $request->validated();
        $service = new AuthService();
        $token = $service->register($inputs);
        return response()->json([
            'status' => true,
            'message' => 'User Created Successfully',
            'token' => $token
        ], 200);
    }

    public function login(LoginRequest $request)
    {
        $inputs = $request->validated();
        $service = new AuthService();
        $result = $service->login($inputs);
        return response()->json([
            'status' => $result['status'],
            'message' => $result['message'],
            'token' => $result['token']
        ], $result['http_status']);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
