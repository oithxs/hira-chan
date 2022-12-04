<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Webルート
|--------------------------------------------------------------------------
|
| ここでは，アプリケーションのWebルートを登録することができます．これらの
| ルートは，「web」ミドルウェアグループを含むグループ内のRouteServiceProvider
| によってロードされます．さあ，素晴らしいものを作りましょう
|
*/

/*
|--------------------------------------------------------------------------
| 警告
|--------------------------------------------------------------------------
|
| - パスに config('filament.path') と同じものを使用しないで下さい．
|
*/

// 画面遷移：ログインしていない状態でもアクセス許可
Route::middleware([
    config('jetstream.auth_session'),
    'login.must_verified'
])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });
    Route::get('dashboard', 'App\Http\Controllers\Dashboard\DashboardController@threads')->name('dashboard');
    Route::get('Q_and_A', 'App\Http\Controllers\QandA\QandAController@Q_and_A')->name('Q_and_A');

    Route::get('dashboard/thread/name={thread_name}&id={thread_id}', 'App\Http\Controllers\Dashboard\DashboardController@messages');
    Route::get('dashboard/thread/name={thread_name}&id=', 'App\Http\Controllers\Dashboard\DashboardController@messages');
    Route::get('dashboard/thread/name=&id={thread_id}', 'App\Http\Controllers\Dashboard\DashboardController@messages');
    Route::get('dashboard/thread/name=&id=', 'App\Http\Controllers\Dashboard\DashboardController@messages');
});

// 画面遷移：ログインが必要
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/mypage', 'App\Http\Controllers\MyPage\MyPageController')->name('mypage');
    Route::get('/report/create', 'App\Http\Controllers\Report\FormContactAdministratorController@create')->name('report.create');
});

// CRUD
Route::middleware([
    'PostAccess_only',
])->group(function () {
    Route::middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified'
    ])->group(function () {
        Route::controller(\App\Http\Controllers\Dashboard\ThreadsController::class)->group(function () {
            Route::match(['get', 'post'], 'jQuery.ajax/sendRow', 'store');
        });

        Route::controller(\App\Http\Controllers\Dashboard\HubController::class)->group(function () {
            Route::match(['get', 'post'], 'jQuery.ajax/create_thread', 'store');
        });

        Route::controller(\App\Http\Controllers\Dashboard\LikeController::class)->group(function () {
            Route::match(['get', 'post'], 'jQuery.ajax/like', 'store');
            Route::match(['get', 'post'], 'jQuery.ajax/unlike', 'destroy');
        });

        Route::controller(\App\Http\Controllers\MyPage\UserController::class)->group(function () {
            Route::match(['get', 'post'], 'jQuery.ajax/page_theme', 'update');
        });

        Route::controller(\App\Http\Controllers\Report\FormContactAdministratorController::class)->group(function () {
            Route::match(['get', 'post'], 'report/store', 'store')->name('report.store');
        });
    });

    Route::controller(\App\Http\Controllers\Dashboard\ThreadsController::class)->group(function () {
        Route::match(['get', 'post'], 'jQuery.ajax/getRow', 'show')->name('thread.get');
    });
});
