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


/**
 * UserAuthController constructor.
 *
 * @param UserRegisterInterface $userRegister
 * @param UserLoginInterface $userLogin
 */

    public function __construct(UserRegisterInterface $userRegister, UserLoginInterface $userLogin)
    {
        $this->userRegister = $userRegister;
        $this->userLogin = $userLogin;
    }


/**
 * Register a new user.
 *
 * This method handles user registration by validating the request,
 * creating a new user, and returning a success message with a token.
 *
 * @param UserRegisterRequest $request The request containing user registration details.
 * @return \Illuminate\Http\JsonResponse A JSON response with a success message and token.
 */


    public function register(UserRegisterRequest $request)
    {

        $token = $this->userRegister->register($request);
        return $this->successMessage('Successfully Register new User', $token, 201);

    }


    /**
     * Login a user.
     *
     * This method handles user login by validating the request,
     * attempting to login the user, and returning a success message with a token.
     *
     * @param UserLoginRequest $request The request containing user login details.
     * @return \Illuminate\Http\JsonResponse A JSON response with a success message and token.
     */

    public function login(UserLoginRequest $request)
    {

        try {
            $token = $this->userLogin->login($request);
            return $this->successMessage('Successfully Login User', $token, 200);
        } catch (\Exception $e) {
            return $this->errorMessage('Something went wrong', $e->getMessage(), 500);
        }
    }


    /**
     * Logout a user.
     *
     * This method handles user logout by attempting to logout the user
     * and returning a success message.
     *
     * @param Request $request The request containing user login details.
     * @return \Illuminate\Http\JsonResponse A JSON response with a success message.
     */

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
