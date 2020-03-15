<?php

namespace App\Http\Product;

use App\Domain\Shopify\Product;

trait FavoriteHelpers
{
    /**
     * @param int $id
     * @return Product|bool
     */
    public function getProductFromShopify(int $id)
    {
        $product = (new Product())->loadProductById($id);

        if (!$product) {
            return $this->defaultResponse("Product doesn't exists.", 'error', 404);
        }

        return $product;
    }
}
