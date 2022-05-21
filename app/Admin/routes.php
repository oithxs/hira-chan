<?php

use Illuminate\Routing\Router;
use App\Admin\Controllers\PostController;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {
    $router->get('/', 'HomeController@index')->name('home');
    $router->resource('/users', UserController::class);

    $router->get('/users/release', 'PostController@release')->middleware('AccessGET');
    $router->post('/users/release', 'PostController@release');
});
