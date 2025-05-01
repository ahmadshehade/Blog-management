<?php

namespace App\Services\Auth\UserLoginServices;

use App\Interfaces\Auth\UserLoginInterface\UserLoginInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserLoginAndLogoutService implements UserLoginInterface
{
    /**
     * Summary of login
     * @param \App\Http\Requests\Auth\UserLoginRequest$request
     * @return string|array{data: string, message: null}
     */
    public function login($request)
    {

        $credentials = [
            'email' => $request->validated()['email'],
            'password' => $request->validated()['password'],
        ];

        $user = User::where('email', $credentials['email'])->first();
        if (! $token = auth('api')->attempt($credentials)) {
            return [
                 'data'=>'cannot login',
                 'message'=>null
            ];
        }
        return $token;

    }

    /**
     * /
     * @param mixed $request
     * @return bool
     */
    public function logout($request)
    {
        $user = $request->user();

        $user->logout;

        return true;

    }
}
