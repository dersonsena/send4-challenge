<?php

namespace App\Http\Users;

use App\Http\Controller;
use Illuminate\Support\Facades\Auth;

class MeAction extends Controller
{
    public function __invoke()
    {
        return $this->defaultResponse(Auth::user());
    }
}
