<?php

/**
 * @link https://readouble.com/laravel/9.x/ja/broadcasting.html
 */
return [

    /*
    |--------------------------------------------------------------------------
    | デフォルトのブロードキャスター
    |--------------------------------------------------------------------------
    |
    | このオプションは，イベントをブロードキャストする必要があるときに
    | フレームワークによって使用されるデフォルトのブロードキャスタを制御します．
    | 下記の「connection」配列で定義された接続のいずれかにこれを設定することが
    | できます．
    |
    | Supported: "pusher", "ably", "redis", "log", "null"
    |
    */

    'default' => env('BROADCAST_DRIVER', 'null'),

    /*
    |--------------------------------------------------------------------------
    | ブロードキャストコネクション
    |--------------------------------------------------------------------------
    |
    | ここで，他のシステムやウェブソケットにイベントを送信する際に使用する
    | ブロードキャスト接続をすべて定義します．使用できる接続のサンプルは，
    | この配列の中に含まれています．
    |
    */

    'connections' => [

        'pusher' => [
            'driver' => 'pusher',
            'key' => env('PUSHER_APP_KEY'),
            'secret' => env('PUSHER_APP_SECRET'),
            'app_id' => env('PUSHER_APP_ID'),
            'options' => [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'useTLS' => true,
            ],
        ],

        'ably' => [
            'driver' => 'ably',
            'key' => env('ABLY_KEY'),
        ],

        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
        ],

        'log' => [
            'driver' => 'log',
        ],

        'null' => [
            'driver' => 'null',
        ],

    ],

];
