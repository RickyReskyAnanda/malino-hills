<?php

namespace App\Utils;

class ResponseFormat
{
    
    public static function format($code, $message, $data = null, $meta = null)
    {
        $resCode = [
            'R_200' => 'SUCCESS',
            'R_500' => 'ERROR',
            'R_422' => 'WARNING',
            'R_400' => 'ERROR',
            'R_401' => 'FAILED',
            'R_404' => 'NOT FOUND'
        ];

        $response = [];

        if ($code)
            $response = array_merge($response, ['status' => $resCode['R_'.$code]]);
        if ($code)
            $response = array_merge($response, ['code' => $code]);
        if ($message)
            $response = array_merge($response, ['message' => $message]);
        if ($data)
            $response = array_merge($response, ['data' => $data]);
        if ($meta)
            $response = array_merge($response, ['meta' => $meta]);

        return $response;
    }

}
