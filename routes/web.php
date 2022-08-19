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

// ページ移動（ログインせずとも移動可）
Route::middleware([
    config('jetstream.auth_session'),
    'login.must_verified'
])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });
    Route::get('dashboard', 'App\Http\Controllers\dashboard\DashboardController@threads')->name('dashboard');
    Route::get('Q_and_A', 'App\Http\Controllers\Q_and_A\Q_and_AController@Q_and_A')->name('Q_and_A');

    Route::middleware([
        'Access_log'
    ])->group(function () {
        Route::get('dashboard/thread/name={thread_name}&id={thread_id}', 'App\Http\Controllers\dashboard\DashboardController@messages');
        Route::get('dashboard/thread/name={thread_name}&id=', 'App\Http\Controllers\dashboard\DashboardController@messages');
        Route::get('dashboard/thread/name=&id={thread_id}', 'App\Http\Controllers\dashboard\DashboardController@messages');
        Route::get('dashboard/thread/name=&id=', 'App\Http\Controllers\dashboard\DashboardController@messages');
    });
});

// ページ移動（要ログイン）
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/mypage', 'App\Http\Controllers\mypage\MyPageController')->name('mypage');
    Route::get('/report/create', 'App\Http\Controllers\report\FormContactAdministratorsController@create')->name('report.create');
});

// データ処理
Route::middleware([
    'PostAccess_only',
])->group(function () {
    Route::middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified'
    ])->group(function () {
        Route::controller(\App\Http\Controllers\dashboard\ThreadsController::class)->group(function () {
            Route::match(['get', 'post'], 'jQuery.ajax/sendRow', 'store');
        });

        Route::controller(\App\Http\Controllers\dashboard\HubController::class)->group(function () {
            Route::match(['get', 'post'], 'jQuery.ajax/create_thread', 'store');
        });

        Route::controller(\App\Http\Controllers\dashboard\LikesController::class)->group(function () {
            Route::match(['get', 'post'], 'jQuery.ajax/like', 'store');
            Route::match(['get', 'post'], 'jQuery.ajax/unlike', 'destroy');
        });

        Route::controller(\App\Http\Controllers\mypage\UsersController::class)->group(function () {
            Route::match(['get', 'post'], 'jQuery.ajax/page_thema', 'update');
        });

        Route::controller(\App\Http\Controllers\report\FormContactAdministratorsController::class)->group(function () {
            Route::match(['get', 'post'], 'report/store', 'store')->name('report.store');
        });
    });

    Route::controller(\App\Http\Controllers\dashboard\ThreadsController::class)->group(function () {
        Route::match(['get', 'post'], 'jQuery.ajax/getRow', 'show');
    });
});

Route::controller(\App\Http\Controllers\mail\UsersController::class)->group(function () {
    // アカウント登録キャンセル
    Route::get('/account/delete/{id}/{hash}', 'destroy')->middleware('auth')->name('account/delete');
});
