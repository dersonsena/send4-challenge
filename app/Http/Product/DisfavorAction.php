<?php

namespace App\Http\Product;

use App\Domain\Product\ProductUser;
use App\Domain\Shopify\Product;
use App\Domain\User\User;
use App\Http\Controller;
use App\Jobs\FavoriteMailJob;
use App\Mail\FavoriteMail;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DisfavorAction extends Controller
{
    use FavoriteHelpers;

    public function __invoke(int $id)
    {
        $userId = Auth::user()->getAuthIdentifier();
        $product = $this->getProductFromShopify($id);

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
        $delay = Carbon::now()->addSeconds(env('MAIL_FAVORITE_DELAY', 7));

        $job = (new FavoriteMailJob($user, $product, $favorites, FavoriteMail::DISFAVOR))
            ->delay($delay)
            ->onQueue(env('MAIL_QUEUE', 'mail'));

        dispatch($job);

        return $this->defaultResponse("Product was disfavored successfully.", 'success', 200);
    }
}
