<?php

namespace App\Jobs;

use App\Domain\Shopify\Product;
use App\Domain\User\User;
use App\Mail\FavoriteMail;
use Illuminate\Support\Facades\Mail;

class FavoriteMailJob extends Job
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var Product
     */
    private $product;

    /**
     * @var Product[]
     */
    private $favoritedProducts;

    /**
     * @var string
     */
    private $action = FavoriteMail::FAVORITE;

    /**
     * @var int
     */
    public $tries = 5;

    public function __construct(
        User $user,
        Product $product,
        array $favoritedProducts,
        string $action
    ) {
        $this->user = $user;
        $this->product = $product;
        $this->favoritedProducts = $favoritedProducts;
        $this->action = $action;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $mail = new FavoriteMail($this->user, $this->product, $this->favoritedProducts);
        $mail->setAction($this->action);

        Mail::send($mail);
    }
}
