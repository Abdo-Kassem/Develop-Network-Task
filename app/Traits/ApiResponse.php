<?php

namespace App\Traits;

trait ApiResponse
{
    public function successResponse($data, $message, $statusCode)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    public function errorResponse($message, $statusCode)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], $statusCode);
    }
}