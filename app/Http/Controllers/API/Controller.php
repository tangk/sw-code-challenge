<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\JsonResponse;

abstract class Controller
{
    protected function sendResponse($data, int $code = 200): JsonResponse
    {
        $response = ($code >= 200 && $code < 300) ? ['data' => $data] : ['error' => $data];
        return response()->json($response, $code ?? 500);
    }
}
