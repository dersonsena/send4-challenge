<?php

namespace App\Http\Product;

use App\Domain\Product\ProductUser;
use App\Domain\Shopify\Product;
use App\Domain\User\User;
use App\Http\Controller;
use App\Jobs\FavoriteMailJob;
use App\Mail\FavoriteMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class FavoriteAction extends Controller
{
    use FavoriteHelpers;

    public function __invoke(int $id)
    {
        $userId = Auth::user()->getAuthIdentifier();
        $product = $this->getProductFromShopify($id);

        if (ProductUser::countProductsOfTheUser($userId, $product) > 0) {
            return $this->defaultResponse("This product is already in your favorites list.", 'success', 200);
        }

        if (!ProductUser::favoriteProduct($userId, $product)) {
            return $this->defaultResponse("There was error on favorite this product.", 'error', 409);
        }

        return $this->defaultResponse("Product was favorited successfully.", 'success', 200);
    }
}
