<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MeAction extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function handle()
    {
        return $this->defaultResponse(Auth::user());
    }
}
