<?php

namespace App\Infra\Rest;

class EndpointResolver
{
    /**
     * @param string $endpoint
     * @return string
     */
    public static function getApiEndpoint(string $endpoint): string
    {
        $baseUrl = 'https://'. env('SHOPIFY_API_KEY') .':'. env('SHOPIFY_PASSWORD') .'@'. env('SHOPIFY_SHOP_NAME') . '.myshopify.com';
        return $baseUrl . $endpoint;
    }
}
