<?php

namespace App\Http\Product;

use App\Domain\Product\ProductUser;
use App\Domain\Shopify\Product;
use App\Domain\User\User;
use App\Http\Controller;
use App\Mail\FavoriteNotification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class FavoriteAction extends Controller
{
    public function handle(int $id)
    {
        $product = (new Product())->loadProductById($id);

        if (!$product) {
            return $this->defaultResponse("Product doesn't exists.", 'error', 404);
        }

        $userId = Auth::user()->getAuthIdentifier();

        /** @var Collection $productsOfTheUser */
        $productsOfTheUser = ProductUser::where(['product_id' => $product->id, 'user_id' => $userId])->get();

        if ($productsOfTheUser->count() > 0) {
            return $this->defaultResponse("This product is already in your favorites list.", 'success', 200);
        }

        $productUser = new ProductUser();
        $productUser->product_id = $product->id;
        $productUser->user_id = $userId;

        if (!$productUser->save()) {
            return $this->defaultResponse("There was error on favorite this product.", 'error', 409);
        }

        $user = User::find($userId);
        $favorites = ProductUser::getFavoritesList($userId);

        Mail::send(new FavoriteNotification($user, $product, $favorites));

        return $this->defaultResponse("Product was favorited successfully.", 'success', 200);
    }
}
