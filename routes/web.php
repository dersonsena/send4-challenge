<?php
/** @var \Laravel\Lumen\Routing\Router $router */

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('/auth/login', 'Auth\\LoginAction@handle');
});

$router->group(['prefix' => 'api', 'middleware' => ['auth']], function () use ($router) {
    // Users
    $router->get('/users/me', 'Users\\MeAction@handle');
    $router->post('/users/register', 'Users\\RegisterAction@handle');

    // Product
    $router->post('/products/favorite/{id}', 'Product\\FavoriteAction@handle');
    $router->post('/products/disfavor/{id}', 'Product\\DisfavorAction@handle');
});
