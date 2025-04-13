<?php

namespace App\Traits;

trait HttpResponses
{

    public function response($key, $message, $data = [], $statusCode)
    {

        return response()->json([
            'key' => $key,
            'msg' => $message,
            'data' => $data
        ], $statusCode);
    }


    public function successResponse($message = 'تم بنجاح')
    {
        return $this->response('success', $message, [], 200);
    }

    public function successWithDataResponse($data)
    {
        return $this->response('success', 'تم بنجاح', $data, 200);
    }

   public function successWithDataAndMessageResponse($message, $data)
    {
        return $this->response('success', $message, $data, 200);
    }

    public function failureResponse($message)
    {
        return $this->response('failure', $message, [], 400);
    }
}
