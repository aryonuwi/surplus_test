<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function responseSuccess($response,$message = '')
    {
        return response()->json([
            "status"    => "success",
            "message"   => $message,
            "result"    => $response
        ], 200);
    }

    public function responseCreate($response,$message = '')
    {
        return response()->json([
            "status"    => "success",
            "message"   => $message,
            "result"    =>  $response
        ], 201);
    }

    public function responseFailed($response,$message='')
    {
        return response()->json([
            "status"    => "failed",
            "message"   => $message,
            "result"    => $response
        ], 400);
    }

}


