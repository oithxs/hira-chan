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

// 画面遷移
Route::get('/', function() { return view('welcome');});
Route::get('/account/delete/{id}/{hash}', 'App\Http\Controllers\AccountDelete')->middleware('auth')->name('account/delete');

// URLからのアクセス対策
Route::middleware([
    'AccessGET'
])->group(function () {
    Route::get('jQuery.ajax/getRow', "App\Http\Controllers\jQuery_ajax@get_allRow");
    Route::get('jQuery.ajax/sendRow', "App\Http\Controllers\jQuery_ajax@send_Row");
    Route::get('jQuery.ajax/create_thread', "App\Http\Controllers\jQuery_ajax@create_thread");
    Route::get('jQuery.ajax/like', "App\Http\Controllers\jQuery_ajax@like");
});

// データ処理
Route::post('jQuery.ajax/getRow', "App\Http\Controllers\jQuery_ajax@get_allRow");
Route::post('jQuery.ajax/sendRow', "App\Http\Controllers\jQuery_ajax@send_Row");
Route::post('jQuery.ajax/create_thread', "App\Http\Controllers\jQuery_ajax@create_thread");
Route::post('jQuery.ajax/like', "App\Http\Controllers\jQuery_ajax@like");

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');
    Route::get('/hub', 'App\Http\Controllers\showTablesCTL')->name('hub');
    Route::get('hub/thread_name={thread_name}/id={thread_id}', 'App\Http\Controllers\keizibanCTL')->middleware('Access_log')->name('keiziban');
    Route::get('/mypage', 'App\Http\Controllers\MyPage')->name('mypage');
});
