<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * アプリケーションのグローバルなHTTPミドルウェアスタック．
     *
     * これらのミドルウェアは，アプリケーションへのすべてのリクエストの際に実行される．
     *
     * @link https://readouble.com/laravel/9.x/ja/middleware.html
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \Fruitcake\Cors\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * アプリケーションのルートミドルウェア群．
     *
     * @link https://readouble.com/laravel/9.x/ja/middleware.html
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * アプリケーションのミドルウェア．
     *
     * これらのミドルウェアは，グループに割り当てることも，個別に使用することも可能．
     *
     * @link https://readouble.com/laravel/9.x/ja/middleware.html
     *
     * @var array<string, class-string|string>
     */
    protected $routeMiddleware = [
        'access_log' => \App\Http\Middleware\AccessLog::class,
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'PostAccess_only' => \App\Http\Middleware\PostAccessOnly::class,
        'login.must_verified' => \App\Http\Middleware\MustAuthVerified::class
    ];

    /**
     * ミドルウェアの優先順位をソートしたリスト．
     *
     * これにより，非グローバルなミドルウェアは常に指定された順序になるように強制される．
     *
     * @link https://readouble.com/laravel/9.x/ja/middleware.html
     *
     * @var string[]
     */
    protected $middlewarePriority = [
        \App\Http\Middleware\PostAccessOnly::class,
        \Illuminate\Cookie\Middleware\EncryptCookies::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \Illuminate\Contracts\Auth\Middleware\AuthenticatesRequests::class,
        \Illuminate\Routing\Middleware\ThrottleRequests::class,
        \Illuminate\Routing\Middleware\ThrottleRequestsWithRedis::class,
        \Illuminate\Contracts\Session\Middleware\AuthenticatesSessions::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
        \Illuminate\Auth\Middleware\Authorize::class,
    ];
}
