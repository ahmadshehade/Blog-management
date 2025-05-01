<?php

namespace App\Services\Auth\AdminLoginServices;

use App\Interfaces\Auth\AdminLoginInterface\AdminLoginInterface;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminLoginService implements AdminLoginInterface
{
    /**
     * Summary of login
     * @param \App\Http\Requests\Auth\AdminLoginRequest $request
     * @return string|array{data: string, message: null}
     * */

    public function login($request)
    {
        $credentials = [
            'email' => $request->validated()['email'],
            'password' => $request->validated()['password'],
        ];
        $admin = Admin::where('email', $credentials['email'])->first();
        if (!$admin) {
            return [
                'error'=>'admin not found',
                'data'=>null
            ];
        }

         if($token=auth('admin')->attempt($credentials)){
             return $token;
         }
        return false;
    }


    /**
     * Logout the admin
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */

    public function logout($request)
    {
        $admin = auth('admin')->user();
        $admin->logout;
        return true;
    }
}
