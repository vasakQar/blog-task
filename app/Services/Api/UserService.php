<?php

namespace App\Services\Api;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function edit($inputs)
    {
        $inputs['full_name'] = $inputs['first_name'] . $inputs['last_name'];
        $inputs['password'] = Hash::make($inputs['password']);
        $user = Auth::user()->update($inputs);
        return $user;
    }
}
