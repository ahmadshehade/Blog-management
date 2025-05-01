<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserLoginRequest;
use App\Http\Requests\Auth\UserRegisterRequest;
use App\Interfaces\Auth\UserLoginInterface\UserLoginInterface;
use App\Interfaces\Auth\UserLoginInterface\UserRegisterInterface;
use Illuminate\Http\Request;
use Nette\Schema\ValidationException;

class UserAuthController extends Controller
{

    protected $userRegister;
    protected $userLogin;

    public function __construct(UserRegisterInterface $userRegister, UserLoginInterface $userLogin)
    {
        $this->userRegister = $userRegister;
        $this->userLogin = $userLogin;
    }

    public function register(UserRegisterRequest $request)
    {

        $token = $this->userRegister->register($request);
        return $this->successMessage('Successfully Register new User', $token, 201);

    }

    public function login(UserLoginRequest $request)
    {

        try {
            $token = $this->userLogin->login($request);
            return $this->successMessage('Successfully Login User', $token, 200);
        } catch (\Exception $e) {
            return $this->errorMessage('Something went wrong', $e->getMessage(), 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $this->userLogin->logout($request);
            return $this->successMessage('Successfully logged out', null, 200);
        } catch (\Exception $e) {
            return $this->errorMessage('Something went wrong', $e->getMessage(), 500);
        }
    }
}
