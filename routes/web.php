<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

// トップ
Route::get('/', [\App\Http\Controllers\TopController::class, 'index'])->name('top');

// ヘルプ
Route::get('/help', fn () => "ヘルプページ")->name('help');

// お問い合わせ
Route::get('/contact', fn () => "お問い合わせページ")->name('contact');

// スレッド関連
Route::prefix('/threads')->group(function () {
    // スレッド一覧
    Route::get('/', fn () => "スレッド一覧ページ")->name('threads.index');

    // スレッド表示
    Route::get('/{id}', fn () => "スレッド表示ページ")->name('threads.show');

    // 閲覧履歴
    Route::get('/history', fn () => "閲覧履歴履歴ページ")->name('threads.history');

    // お気に入りスレッド一覧
    Route::get('/favorite', fn () => "お気に入りスレッド一覧ページ")->name('threads.favorite');
});

// マイページ
Route::get('/mypage', fn () => "マイページ")->name('mypage');


/**
 * 以下，プロジェクト作成時に自動生成されたルーティング
 */
Route::get('/welcome', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
