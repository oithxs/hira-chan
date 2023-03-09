<?php

namespace App\Providers;

use App\Actions\Jetstream\DeleteUser;
use Illuminate\Support\ServiceProvider;
use Laravel\Jetstream\Jetstream;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * 任意のアプリケーションサービスを登録する．
     *
     * @link https://readouble.com/laravel/9.x/ja/providers.html
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * あらゆるアプリケーションサービスをブートストラップする．
     *
     * @link https://jetstream.laravel.com/2.x/features/authentication.html
     *
     * @return void
     */
    public function boot()
    {
        $this->configurePermissions();

        Jetstream::deleteUsersUsing(DeleteUser::class);
    }

    /**
     * アプリケーション内で利用できる権限を設定する．
     *
     * @return void
     */
    protected function configurePermissions()
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::permissions([
            'create',
            'read',
            'update',
            'delete',
        ]);
    }
}
