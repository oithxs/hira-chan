<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| APIルート
|--------------------------------------------------------------------------
|
| ここでは，アプリケーションのAPIルートを登録することができます．
| これらのルートは，ミドルウェアグループ「api」を割り当てられたグループ内の
| RouteServiceProviderによってロードされます．API構築を楽しんでください
|
*/

Route::apiResource('/hub', \App\Http\Controllers\API\HubController::class);
Route::apiResource('/threadPrimaryCategory', \App\Http\Controllers\API\ThreadPrimaryCategoryController::class);
Route::apiResource('/threadSecondaryCategory', \App\Http\Controllers\API\ThreadSecondaryCategoryController::class);


// 要認証
Route::middleware([
    'auth:sanctum',
    'verified'
])->group(function () {
    Route::get('/me', fn (Request $request) => $request->user())->name('user.current');
});
