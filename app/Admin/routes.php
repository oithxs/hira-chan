<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {
    $router->get('/', 'HomeController@index')->name('home');
    $router->get('/users/create/mail', 'MailController@show');
    $router->resource('/users', UserController::class);

    $router->get('/users/mail', 'PostController')->middleware('AccessGET');
    $router->post('/users/mail', 'PostController');
});
