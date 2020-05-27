<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

//import auth facades
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    //

    //Add this method to the Controller class
    protected function respondWithToken($token)
    {
        return response()->json([
            'token' => $token,
            'data' => Auth::user(),
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ], 200);
    }

    protected function customResponse($message = 'success', $status = 200)
    {
        return response(['status' => $status, 'message' => $message], $status);
    }
}
