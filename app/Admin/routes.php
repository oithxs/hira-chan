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

    $router->resource('/general/users', General\UserController::class);

    $router->middleware([
        'PostAccess_only'
    ])->group(function (Router $router) {
        $router->match(['get', 'post'], '/general/users/create/mail', General\MailController::class);
    });
});
