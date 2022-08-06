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

// ページ移動（非ログイン）
Route::get('/', function () {
    return view('welcome');
})->middleware([
    config('jetstream.auth_session')
]);

// ページ移動（要ログイン）
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('dashboard', 'App\Http\Controllers\dashboard\DashboardController@threads')->name('dashboard');

    Route::middleware([
        'Access_log'
    ])->group(function () {
        Route::get('dashboard/thread/name={thread_name}&id={thread_id}', 'App\Http\Controllers\dashboard\DashboardController@messages');
        Route::get('dashboard/thread/name={thread_name}&id=', 'App\Http\Controllers\dashboard\DashboardController@messages');
        Route::get('dashboard/thread/name=&id={thread_id}', 'App\Http\Controllers\dashboard\DashboardController@messages');
        Route::get('dashboard/thread/name=&id=', 'App\Http\Controllers\dashboard\DashboardController@messages');
    });

    Route::get('/mypage', 'App\Http\Controllers\mypage\MyPageController')->name('mypage');
});

// データ処理
Route::middleware([
    'PostAccess_only',
])->group(function () {
    Route::controller(\App\Http\Controllers\dashboard\ThreadsController::class)->group(function () {
        Route::match(['get', 'post'], 'jQuery.ajax/getRow', 'show');
        Route::match(['get', 'post'], 'jQuery.ajax/sendRow', 'store');
    });

    Route::controller(\App\Http\Controllers\dashboard\HubController::class)->group(function () {
        Route::match(['get', 'post'], 'jQuery.ajax/create_thread', 'store');
    });

    Route::controller(\App\Http\Controllers\dashboard\LikesController::class)->group(function () {
        Route::match(['get', 'post'], 'jQuery.ajax/like', 'store');
        Route::match(['get', 'post'], 'jQuery.ajax/unlike', 'destroy');
    });

    Route::controller(\App\Http\Controllers\dashboard\UsersController::class)->group(function () {
        Route::match(['get', 'post'], 'jQuery.ajax/page_thema', 'update');
    });
});

// アカウント登録キャンセル
Route::get('/account/delete/{id}/{hash}', 'App\Http\Controllers\AccountDelete')->middleware('auth')->name('account/delete');
