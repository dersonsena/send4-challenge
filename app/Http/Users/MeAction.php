<?php

namespace App\Http\Users;

use App\Http\Controller;
use Illuminate\Support\Facades\Auth;

class MeAction extends Controller
{
    public function handle()
    {
        return $this->defaultResponse(Auth::user());
    }
}
