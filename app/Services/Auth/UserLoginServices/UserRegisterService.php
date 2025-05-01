<?php

namespace App\Services\Auth\UserLoginServices;

use App\Interfaces\Auth\UserLoginInterface\UserRegisterInterface;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserRegisterService implements UserRegisterInterface
{

    /**
     * Summary of register
     * @param  \App\Http\Requests\Auth\UserRegisterRequest $request
     * @return string|array{data: string, message: null}
     */

    public function register($request)
    {

        try {
            DB::beginTransaction();

            $validatedData = $request->validated();

            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
            ]);


            if(! $token=auth('api')->attempt([
                "email"=>$validatedData['email'],
               "password"=> $validatedData['password']
                ])){
                return [
                    'message'=>'Error',
                    'data'=>null,
                ];

            }


            DB::commit();

            return $token;


        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }


    }
}
