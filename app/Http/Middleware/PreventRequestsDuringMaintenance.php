<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance as Middleware;

class PreventRequestsDuringMaintenance extends Middleware
{
    /**
     * メンテナンスモードが有効な間，到達可能であるべき URI．
     *
     * @link https://readouble.com/laravel/9.x/ja/configuration.html
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];
}
