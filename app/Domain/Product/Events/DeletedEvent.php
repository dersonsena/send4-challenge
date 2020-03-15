<?php

namespace App\Domain\Product\Events;

use App\Domain\Product\ProductUser;
use App\Mail\FavoriteMail;

class DeletedEvent
{
    use Notify;

    /**
     * @var ProductUser
     */
    private $productUser;

    public function __construct(ProductUser $productUser)
    {
        $this->productUser = $productUser;
        $this->handle(FavoriteMail::DISFAVOR);
    }
}
