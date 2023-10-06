<?php

namespace App\Services\Api;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function register($inputs)
    {
        $inputs['full_name'] = $inputs['first_name'] . $inputs['last_name'];
        $inputs['password'] = Hash::make($inputs['password']);
        $user = User::create($inputs);
        $token = $user->createToken("API TOKEN")->plainTextToken;
        return $token;
    }

    public function login($inputs)
    {
        if (!Auth::attempt($inputs)) {
            return [
                'status' => false,
                'http_status' => 401,
                'message' => 'Email & Password does not match with our record.',
                'token' => null
            ];
        }

        $user = Auth::user();
        $token = $user->createToken("API TOKEN")->plainTextToken;

        return [
            'status' => true,
            'http_status' => 200,
            'message' => 'User Logged In Successfully',
            'token' => $token
        ];
    }
}
