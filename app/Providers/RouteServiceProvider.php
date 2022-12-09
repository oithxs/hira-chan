<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * アプリケーションの「ホーム」ルートへのパス．
     *
     * これは、Laravel認証で、ログイン後にユーザーをリダイレクトするために使用される．
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * アプリケーションのコントローラ名前空間．
     *
     * この名前空間を指定すると、コントローラのルート宣言の先頭に自動的にこの名前空間が追加される．
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * ルートモデルのバインディング、パターンフィルタなどを定義する．
     *
     * @link https://readouble.com/laravel/8.x/ja/routing.html
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * アプリケーションのレートリミッターを設定する．
     *
     * @link https://readouble.com/laravel/8.x/ja/routing.html
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
