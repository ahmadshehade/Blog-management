<?php

namespace App\Services\Auth\AdminLoginServices;

use App\Interfaces\Auth\AdminLoginInterface\AdminLoginInterface;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminLoginService implements AdminLoginInterface
{

    public function login($request)
    {
        $credentials = $request->only('email', 'password');
        $admin = Admin::where('email', $credentials['email'])->first();
        if (!$admin) {
            return response()->json(['error' => 'Admin not found'], 404);
        }

        if ($admin && Hash::check($credentials['password'], $admin->password)) {
            $token = $admin->createToken('admin_auth')->plainTextToken;

            return $token;
        }
        return false;
    }

    public function logout($request)
    {
        $admin = auth('admin')->user();
        $admin->currentAccessToken()->delete();
        return true;
    }
}
