<?php

namespace App\Http\Product;

use App\Domain\Product\ProductUser;
use App\Http\Controller;
use Illuminate\Support\Facades\Auth;

class FavoritesAction extends Controller
{
    public function handle()
    {
        $userId = Auth::user()->getAuthIdentifier();
        $favorites = ProductUser::getFavoritesList($userId);

        return $this->defaultResponse($favorites);
    }
}
