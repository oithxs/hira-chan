<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class MustAuthVerified
{
    /**
     * 受信したリクエストを処理する．
     *
     * @link https://readouble.com/laravel/9.x/ja/verification.html
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $redirectToRoute
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse|null
     */
    public function handle($request, Closure $next, $redirectToRoute = null)
    {
        if (Auth::check()) {
            if (
                !$request->user() ||
                ($request->user() instanceof MustVerifyEmail &&
                    !$request->user()->hasVerifiedEmail())
            ) {
                return $request->expectsJson()
                    ? abort(403, 'Your email address is not verified.')
                    : Redirect::guest(URL::route($redirectToRoute ?: 'verification.notice'));
            }
        }

        return $next($request);
    }
}
