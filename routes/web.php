<?php
/** @var \Laravel\Lumen\Routing\Router $router */

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('/auth/login', 'Auth\\LoginAction@handle');

    $router->get('/users/me', 'Users\\MeAction@handle');
    $router->post('/users/register', 'Users\\RegisterAction@handle');
});
