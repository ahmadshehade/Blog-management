<?php

namespace App\Interfaces\Auth\UserLoginInterface;

interface UserLoginInterface
{
    public function login($request);

    public function logout($request);
}
