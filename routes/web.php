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
    Route::match(['get', 'post'], 'jQuery.ajax/getRow', "App\Http\Controllers\dashboard\ThreadsController@show");
    Route::match(['get', 'post'], 'jQuery.ajax/sendRow', "App\Http\Controllers\jQuery_ajax@send_Row");
    Route::match(['get', 'post'], 'jQuery.ajax/create_thread', "App\Http\Controllers\jQuery_ajax@create_thread");
    Route::match(['get', 'post'], 'jQuery.ajax/like', "App\Http\Controllers\jQuery_ajax@like");
    Route::match(['get', 'post'], 'jQuery.ajax/unlike', "App\Http\Controllers\jQuery_ajax@unlike");
    Route::match(['get', 'post'], 'jQuery.ajax/page_thema', "App\Http\Controllers\jQuery_ajax@page_thema");
});

// アカウント登録キャンセル
Route::get('/account/delete/{id}/{hash}', 'App\Http\Controllers\AccountDelete')->middleware('auth')->name('account/delete');
