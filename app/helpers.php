<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;

if (!function_exists('responseOk')) {
    function responseOk(): JsonResponse
    {
        return response()->json([
            'status' => 'success',
        ]);
    }
}
if (!function_exists('responseFailed')) {
    function responseFailed(string $message, int $code = 400): JsonResponse
    {
        return response()->json([
            'message' => $message,
        ], $code);
    }
}
if (!function_exists('route_like')) {
    function route_like($route)
    {
        return Route::is($route . ".*");
    }
}
