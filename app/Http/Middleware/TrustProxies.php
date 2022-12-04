<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;

/**
 * @link https://readouble.com/laravel/9.x/ja/requests.html
 */
class TrustProxies extends Middleware
{
    /**
     * このアプリケーションの信頼できるプロキシ．
     *
     * @var array<int, string>|string|null
     */
    protected $proxies;

    /**
     * プロキシを検出するために使用すべきヘッダ．
     *
     * @var int
     */
    protected $headers =
        Request::HEADER_X_FORWARDED_FOR |
        Request::HEADER_X_FORWARDED_HOST |
        Request::HEADER_X_FORWARDED_PORT |
        Request::HEADER_X_FORWARDED_PROTO |
        Request::HEADER_X_FORWARDED_AWS_ELB;
}
