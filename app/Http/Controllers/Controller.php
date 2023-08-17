<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function success($data = [], $code = 200)
    {
        return response()->json([
            'code' => $code,
            'data' => $data
        ]);
    }

    public function error($msg)
    {
        return response()->json([
            'code' => 400,
            'msg' => $msg
        ]);
    }
}
