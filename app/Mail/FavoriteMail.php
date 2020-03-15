<?php

namespace App\Mail;

use App\Domain\Shopify\Product;
use App\Domain\User\User;
use Illuminate\Mail\Mailable;

class FavoriteNotification extends Mailable
{
    /**
     * @var int
     */
    const FAVORITE = 1;

    /**
     * @var int
     */
    const DISFAVOR = 2;

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
    private $action = FavoriteNotification::FAVORITE;

    public function __construct(
        User $user,
        Product $product,
        array $favoritedProducts = []
    ) {
        $this->user = $user;
        $this->product = $product;
        $this->favoritedProducts = $favoritedProducts;
    }

    public function build()
    {
        $action = $this->getActionName();

        return $this->subject("Produto {$action}")
            ->to($this->user->email, $this->user->name)
            ->markdown('mail.favoriteNotification')
            ->with([
                'user' => $this->user,
                'product' => $this->product,
                'favoritedProducts' => $this->favoritedProducts,
                'action' => $action
            ]);
    }

    /**
     * @return string
     */
    private function getActionName(): string
    {
        switch ($this->action) {
            case static::FAVORITE:
                return 'Favoritado';
            case static::DISFAVOR:
                return 'Desfavoritado';
        }
    }

    /**
     * @param string $action
     * @return FavoriteNotification
     */
    public function setAction(string $action): FavoriteNotification
    {
        $this->action = $action;
        return $this;
    }
}
