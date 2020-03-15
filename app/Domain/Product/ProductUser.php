<?php

namespace App\Domain\Product;

use App\Domain\Product\Events\CreatedEvent;
use App\Domain\Product\Events\DeletedEvent;
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
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => CreatedEvent::class,
        'deleted' => DeletedEvent::class
    ];

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

    /**
     * @param int $userId
     * @param Product $product
     * @return int
     */
    public static function countProductsOfTheUser(int $userId, Product $product): int
    {
        /** @var Collection $productsOfTheUser */
        $productsOfTheUser = static::where(['product_id' => $product->id, 'user_id' => $userId])->get();
        return $productsOfTheUser->count();
    }

    /**
     * @param int $userId
     * @param Product $product
     * @return bool
     */
    public static function favoriteProduct(int $userId, Product $product): bool
    {
        $productUser = new static();
        $productUser->product_id = $product->id;
        $productUser->user_id = $userId;

        return $productUser->save();
    }
}
