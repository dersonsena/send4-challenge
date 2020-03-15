<?php
/** @var \Laravel\Lumen\Routing\Router $router */
use App\Http\Auth\LoginAction;
use App\Http\Product\DisfavorAction;
use App\Http\Product\FavoriteAction;
use App\Http\Product\FavoritesAction;
use App\Http\Users\MeAction;
use App\Http\Users\RegisterAction;
use App\Jobs\TestMailJob;
use App\Mail\TestMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('/auth/login', LoginAction::class);

    $router->get('/mail', function () {
        Mail::send(new TestMail());
        return 'Email sent.';
    });

    $router->get('/mail-job', function () {
        $job = (new TestMailJob())->delay(Carbon::now()->addSeconds(7));
        dispatch($job);

        return 'Job queued.';
    });
});

$router->group(['prefix' => 'api', 'middleware' => ['auth']], function () use ($router) {
    // Users
    $router->get('/users/me', MeAction::class);
    $router->post('/users/register', RegisterAction::class);

    // Product
    $router->get('/products/favorites', FavoritesAction::class);
    $router->post('/products/favorite/{id}', FavoriteAction::class);
    $router->post('/products/disfavor/{id}', DisfavorAction::class);
});
