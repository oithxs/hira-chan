<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PostAccessOnly
{
    /**
     * GETメソッドでアクセスされた場合，404エラーを表示する．
     *
     * @link https://readouble.com/laravel/9.x/ja/requests.html
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->isMethod('get')) {
            abort(404);
            exit;
        }
        return $next($request);
    }
}
