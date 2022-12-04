<?php

/**
 * @link https://readouble.com/laravel/9.x/ja/filesystem.html
 */
return [

    /*
    |--------------------------------------------------------------------------
    | デフォルトのファイルシステムディスク
    |--------------------------------------------------------------------------
    |
    | ここでは，フレームワークが使用するデフォルトのファイルシステムディスクを
    | 指定することができます．「local」ディスクと，さまざまなクラウドベースの
    | ディスクが，アプリケーションで利用可能です．そのまま保存してください
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | ファイルシステムディスク
    |--------------------------------------------------------------------------
    |
    | ここでは，ファイルシステムの「disks」をいくつでも設定でき，
    | 同じドライバーの複数のディスクを設定することもできます．必要なオプションの
    | 一例として，各ドライバにデフォルトが設定されています．
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | シンボリックリンク
    |--------------------------------------------------------------------------
    |
    | ここでは，`storage:link` Artisanコマンドが実行されたときに作成される
    | シンボリックリンクを設定することができます．配列のキーにはリンクの場所を，
    | 値にはそのターゲットを指定します．
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
