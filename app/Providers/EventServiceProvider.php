<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * アプリケーションのイベントリスナーマッピング．
     *
     * @link https://readouble.com/laravel/9.x/ja/events.html
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * アプリケーションのイベントを登録します．
     *
     * @link https://readouble.com/laravel/9.x/ja/events.html
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
