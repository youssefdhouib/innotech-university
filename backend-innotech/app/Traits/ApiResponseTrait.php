<?php

namespace App\Traits;

trait ApiResponseTrait
{
    public function successResponse(string $message, $data = null, int $code = 200): \Illuminate\Http\JsonResponse
    {
        $response = [
            'code'     => $code,
            'message'  => $message,
            'codeLang' => app()->getLocale(), // renamed here
        ];

        if (!is_null($data)) {
            $response['data'] = $data;
        }

        return response()->json($response, $code);
    }

    public function errorResponse(string $message, $errors = null, int $code = 400): \Illuminate\Http\JsonResponse
    {
        $response = [
            'code'     => $code,
            'message'  => $message,
            'codeLang' => app()->getLocale(),
        ];

        if (!is_null($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }

}
