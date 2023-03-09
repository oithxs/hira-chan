<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * 報告されない例外タイプのリスト．
     *
     * @link https://readouble.com/laravel/9.x/ja/errors.html
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * 検証の例外のために決してフラッシュされない入力のリスト．
     *
     * @link https://laravel.com/api/5.5/Illuminate/Foundation/Exceptions/Handler.html
     * @todo このリンクだとよく分からないので良さげなページを探す．
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * アプリケーションの例外処理コールバックを登録する．
     *
     * @link https://readouble.com/laravel/9.x/ja/errors.html
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
