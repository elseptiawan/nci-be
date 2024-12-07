<?php

namespace App\Helpers;

class ApiResponseHelper
{
    /**
     * Return a successful response.
     */
    public static function success($data = [], $message = 'Success', $statusCode = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    /**
     * Return an error response.
     */
    public static function error($message = 'Error', $statusCode = 400, $errors = [])
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], $statusCode);
    }
}
