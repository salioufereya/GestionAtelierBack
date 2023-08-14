<?php

namespace App\Traits;

trait HttpResponse
{


    protected function success($data, $message = '', $code = 200)
    {
        return response()->json([
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ]);
    }

    protected function error($data, $code=500, $message = null)
    {
        return response()->json([
            'code' => $code,
            'message' => $message,
            'data' => $data

        ]);
    }
}
