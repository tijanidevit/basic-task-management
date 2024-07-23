<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ResponseTrait
{
    public function successResponse($message = "Request completed successfully", $data = null, $statusCode = 200): JsonResponse
    {
        if ($data) {
            return response()->json([
                "success" => true,
                "message" => $message,
                "data" => $data,
            ], $statusCode);
        }
        return response()->json([
            "success" => true,
            "message" => $message,
        ], $statusCode);
    }
    public function createdResponse($message = "Resource created successfully", $data = null, $statusCode = 201): JsonResponse
    {
        if ($data) {
            return response()->json([
                "success" => true,
                "message" => $message,
                "data" => $data,
            ], $statusCode);
        }
        return response()->json([
            "success" => true,
            "message" => $message,
        ], $statusCode);
    }

    public function errorResponse($message = "Unable to complete request", $errors = null, $statusCode = 500): JsonResponse
    {
        if ($errors) {
            return response()->json([
                "success" => false,
                "message" => $message,
                "errors" => $errors,
            ], $statusCode);
        }

        return response()->json([
            "success" => false,
            "message" => $message,
        ], $statusCode);
    }

    public function inputErrorResponse($message = "Invalid input", $statusCode = 422): JsonResponse
    {
        return response()->json([
            "success" => false,
            "message" => $message,
        ], $statusCode);
    }

    public function notFoundResponse($message = "Requested resource not found", $statusCode = 404): JsonResponse
    {
        return response()->json([
            "success" => false,
            "message" => $message,
        ], $statusCode);
    }

    public function paginatedCollection(string $message = "Collection retrieved successfully", mixed $data = null)
    {
        $meta = [
            'currentPage' => $data->currentPage(),
            'hasMorePages' => $data->hasMorePages(),
            'lastPage' => $data->lastPage(),
            'nextPageUrl' => $data->nextPageUrl(),
            'perPage' => $data->perPage(),
            'previousPageUrl' => $data->previousPageUrl(),
            'total' => $data->total(),
            'url' => $data->path()
        ];

        $responseData = array_merge(['success' => true, 'message' =>$message], ['data' => $data], $meta);
        return response()->json($responseData, 200);
    }

    public function unauthorizedResponse($message = "Unathorized access to requested resource", $statusCode = 403): JsonResponse
    {
        return response()->json([
            "success" => false,
            "message" => $message,
        ], $statusCode);
    }
}
