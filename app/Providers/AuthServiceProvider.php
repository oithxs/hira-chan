<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * アプリケーションのポリシーマッピング．
     *
     * @link https://readouble.com/laravel/9.x/ja/authorization.html
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * 任意の認証 / 認可サービスを登録する．
     *
     * @link https://readouble.com/laravel/9.x/ja/authorization.html
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
