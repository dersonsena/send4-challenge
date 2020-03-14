<?php

namespace App\Domain\Shopify;

use App\Infra\Rest\EndpointResolver;
use ErrorException;
use Exception;

/**
 * Class Product
 * @package App\Domain\Shopify
 *
 * @property int $id
 * @property string $title
 */
class Product
{
    /**
     * @var array
     */
    private $attributes = [];

    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    public function __get($name)
    {
        if (!isset($this->attributes[$name])) {
            throw new Exception("The '{$name}' attribute doesn't exists.");
        }

        return $this->attributes[$name];
    }

    /**
     * @param int $id
     * @return Product|bool
     */
    public function loadProductById(int $id)
    {
        $endpoint = EndpointResolver::getApiEndpoint("/products/{$id}.json");

        try {
            $payload = json_decode(file_get_contents($endpoint));
            $product = (array)$payload->product;

            if (isset($product['errors'])) {
                return false;
            }

            $this->attributes = $product;

            return $this;
        } catch (ErrorException $e) {
            return false;
        }
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
