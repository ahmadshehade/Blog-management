<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AdminLoginRequest;
use App\Interfaces\Auth\AdminLoginInterface\AdminLoginInterface;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{

    protected  $adminLogin;

    public function __construct(AdminLoginInterface $adminLogin)
    {
        $this->adminLogin=$adminLogin;
    }

    public function  login(AdminLoginRequest $request){
       try{
           $token= $this->adminLogin->login($request);
           return $this->successMessage('Successfully Admin login',$token,201);
       }catch (\Exception $e){
           return  $this->errorMessage('someThink error !'.$e->getMessage() ,null,500);
       }

    }

    public function  logout(Request $request){
      try{
          $this->adminLogin->logout($request);
          return $this->successMessage('Successfully Logout Admin!',null,200);
      }catch (\Exception $e){

          return  $this->errorMessage('someThink error'.$e->getMessage(),null,500);
      }
    }
}
