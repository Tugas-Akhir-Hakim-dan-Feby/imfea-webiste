<?php

namespace App\Http\Facades;

use Illuminate\Http\Response;

class MessageFixer extends Response
{
    const ERROR = "ERROR";

    const SUCCESS = "SUCCESS";

    const WARNING = "WARNING";

    public static function successMessage($message, $route)
    {
        return redirect($route)->with('successMessage', $message);
    }

    public static function warningMessage($message, $route)
    {
        return redirect($route)->with('warningMessage', $message);
    }

    public static function dangerMessage($message, $route)
    {
        return redirect($route)->with('dangerMessage', $message);
    }

    public static function customApiMessage($status, $message, $statusCode, $data = [], $isLogin = false, $token = null)
    {
        $data = [
            'status' => $status,
            'message' => $message,
            'data' => $data,
            'status_code' => $statusCode,
        ];

        if ($isLogin) {
            $data['token'] = $token;
        }

        return response()->json($data, $statusCode);
    }
}
