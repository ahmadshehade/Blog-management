<?php

namespace App\Interfaces\Auth\AdminLoginInterface;

interface AdminLoginInterface
{
    public function  login($request);


    public function  logout($request);

}
