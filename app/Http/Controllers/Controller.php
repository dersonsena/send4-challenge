<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected function defaultResponse($data, string $status = 'success', int $statusCode = 200)
    {
        $responseData = ['status' => $status, 'data' => $data];

        if ($status === 'error') {
            $responseData = ['status' => $status, 'message' => $data];
        }

        return response()->json($responseData, $statusCode);
    }

    protected function respondWithToken($token, $status = 'success')
    {
        return $this->defaultResponse([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ], $status);
    }
}
