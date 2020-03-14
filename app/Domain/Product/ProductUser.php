<?php

namespace App\Domain\Product;

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
}
