<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * CSRFの検証から除外すべきURI．
     *
     * @link https://readouble.com/laravel/9.x/ja/csrf.html
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];
}
