<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait ApiResponse
{
    /**
     * Build a success response.
     */
    protected function successResponse($data, string $message = null, int $statusCode = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    /**
     * Build an error response.
     */
    protected function errorResponse(string $message, int $statusCode): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'data' => null,
        ], $statusCode);
    }
}
