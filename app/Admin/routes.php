<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {
    $router->controller(App\Admin\Controllers\Dashboard\HomeController::class)->group(function (Router $router) {
        $router->get('/', 'index')->name('home');
    });
    $router->resource('/users', UserController::class);
    $router->get('/users/create/mail', 'MailController@show');

    $router->get('/users/mail', 'PostController')->middleware('AccessGET');
    $router->post('/users/mail', 'PostController');
});
