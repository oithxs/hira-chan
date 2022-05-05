<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function() {
	return view('welcome');
});

Route::post('jQuery.ajax/getRow', "App\Http\Controllers\jQuery_ajax@get_allRow");
Route::post('jQuery.ajax/sendRow', "App\Http\Controllers\jQuery_ajax@send_Row");
Route::post('jQuery.ajax/create_thread', "App\Http\Controllers\jQuery_ajax@create_thread");

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/hub', 'App\Http\Controllers\showTablesCTL')->name('hub');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/keiziban', 'App\Http\Controllers\keizibanCTL')->name('keiziban');
});
