<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class EncryptCookies extends Middleware
{
    /**
     * 暗号化しない方がよいクッキーの名前．
     *
     * @link https://readouble.com/laravel/9.x/ja/responses.html
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];
}
