<?php

namespace App\Http\Controllers\Users;

use App\Domain\User\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterAction extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function handle(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        try {
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = app('hash')->make($request->input('password'));
            $user->save();

            return $this->defaultResponse($user);

        } catch (\Exception $e) {
            return $this->defaultResponse('User Registration Failed!', 'error', 409);
        }
    }
}
