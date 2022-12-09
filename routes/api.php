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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
