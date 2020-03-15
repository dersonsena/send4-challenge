<?php

namespace App\Http\Product;

use App\Domain\Product\ProductUser;
use App\Domain\Shopify\Product;
use App\Domain\User\User;
use App\Http\Controller;
use App\Mail\FavoriteNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class DisfavorAction extends Controller
{
    public function handle(int $id)
    {
        $product = (new Product())->loadProductById($id);

        if (!$product) {
            return $this->defaultResponse("Product doesn't exists.", 'error', 404);
        }

        $userId = Auth::user()->getAuthIdentifier();

        /** @var ProductUser $productToDisfavor */
        $productToDisfavor = ProductUser::where(['product_id' => $product->id, 'user_id' => $userId])->first();

        if (!$productToDisfavor) {
            return $this->defaultResponse("This product doesn't in your favorites list.", 'success', 200);
        }

        if (!$productToDisfavor->delete()) {
            return $this->defaultResponse("There was error on disfavor this product.", 'error', 409);
        }

        $user = User::find($userId);
        $favorites = ProductUser::getFavoritesList($userId);

        $sender = new FavoriteNotification($user, $product, $favorites);
        $sender->setAction(FavoriteNotification::DISFAVOR);

        Mail::send($sender);

        return $this->defaultResponse("Product was disfavored successfully.", 'success', 200);
    }
}
