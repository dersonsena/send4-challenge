<?php

namespace App\Domain\Product;

use App\Domain\Shopify\Product;
use App\Infra\Rest\EndpointResolver;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductUser
 * @package App\Domain\Product
 *
 * @property int $id
 * @property int $product_id
 * @property int $user_id
 */
class ProductUser extends Model
{
    /**
     * @var string
     */
    protected $table = 'products_users';

    /**
     * @param int $userId
     * @return Product[]
     */
    public static function getFavoritesList(int $userId): array
    {
        /** @var Collection $productsOfTheUser */
        $productsOfTheUser = static::where(['user_id' => $userId])->get();

        $ids = array_map(function ($row) {
            return $row->product_id;
        }, $productsOfTheUser->all());

        if (empty($ids)) {
            return [];
        }

        $endpoint = EndpointResolver::getApiEndpoint("/products.json?ids=" . implode(',', $ids));

        $data = (json_decode(file_get_contents($endpoint)))->products;
        $responseData = [];

        foreach ($data as $row) {
            $responseData[] = (new Product((array)$row))->getAttributes();
        }

        return $responseData;
    }
}
