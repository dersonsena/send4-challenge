<?php

namespace App\Domain\Product\Events;

use App\Domain\Product\ProductUser;
use App\Domain\Shopify\Product;
use App\Domain\User\User;
use App\Jobs\FavoriteMailJob;
use Carbon\Carbon;

trait Notify
{
    private function handle(int $action)
    {
        $user = User::find($this->productUser->user_id);
        $product = (new Product())->loadProductById($this->productUser->product_id);
        $favorites = ProductUser::getFavoritesList($this->productUser->user_id);
        $delay = Carbon::now()->addSeconds(env('MAIL_FAVORITE_DELAY', 7));

        $job = (new FavoriteMailJob($user, $product, $favorites, $action))
            ->delay($delay)
            ->onQueue(env('MAIL_QUEUE', 'mail'));

        dispatch($job);
    }
}
