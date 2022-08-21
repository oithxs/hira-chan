<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {
    $router->controller(Dashboard\HomeController::class)->group(function (Router $router) {
        $router->get('/', 'index')->name('home');
    });

    $router->resource('/users', General\UserController::class);
    $router->post('/users/create/mail', 'MailController@show');
});
