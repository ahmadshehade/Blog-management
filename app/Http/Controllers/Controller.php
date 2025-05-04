<?php

namespace App\Http\Controllers;

abstract class Controller
{


    /**
     * success response method.
     *
     * @param string $message
     * @param array $data
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */

    public function successMessage($message, $data, $code)
    {

        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $code);
    }


  
}
