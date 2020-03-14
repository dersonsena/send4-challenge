<?php

namespace App\Domain\Shopify;

use App\Infra\Rest\EndpointResolver;
use Exception;

class Product
{
    /**
     * @var array
     */
    private $attributes = [];

    public function __get($name)
    {
        if (!isset($this->attributes[$name])) {
            throw new Exception("The '{$name}' attribute doesn't exists.");
        }

        return $this->attributes[$name];
    }

    /**
     *
     * @param int $id
     * @return Product
     */
    public function loadProductById(int $id): Product
    {
        $endpoint = EndpointResolver::getApiEndpoint("/admin/api/2020-01/products/{$id}.json");
        $payload = file_get_contents($endpoint);
        $productRaw = (array)(json_decode($payload))->product;

        $this->attributes = $productRaw;

        return $this;
    }
}
