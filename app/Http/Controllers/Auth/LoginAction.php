<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginAction extends Controller
{
    public function handle(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['email', 'password']);

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized User'], 401);
        }

        return $this->respondWithToken($token);
    }
}
