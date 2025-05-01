<?php

namespace App\Services\Auth\UserLoginServices;

use App\Interfaces\Auth\UserLoginInterface\UserLoginInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserLoginAndLogoutService implements UserLoginInterface
{

    public function login($request)
    {

        $credentials = $request->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();
        if ($user && Hash::check($credentials['password'], $user->password)) {
            $token = $user->createToken('auth_token')->plainTextToken;

            return $token;
        }
        return false;

    }

    public function logout($request)
    {
        $user = $request->user();

        $user->currentAccessToken()->delete();

        return true;

    }
}
