<?php

namespace App\Http\Controllers;

abstract class Controller
{

    public function successMessage($message,$data,$code){

        return response()->json([
            'message'=>$message,
            'data'=>$data,
        ],$code);
    }

    public  function errorMessage($message,$data,$code){
        return response()->json([
            'message'=>$message,
            'error'=>$data,
        ],$code);
    }
}
