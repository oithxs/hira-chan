<?php

use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;

/**
 * @link https://readouble.com/laravel/8.x/ja/logging.html
 */
return [

    /*
    |--------------------------------------------------------------------------
    | デフォルトのログチャンネル
    |--------------------------------------------------------------------------
    |
    | このオプションは，ログにメッセージを書き込む際に使用する デフォルトの
    | ログチャンネルを定義します．このオプションで指定する名前は，設定配列
    | 「channels」で定義されているチャネルのうちのひとつと一致しなければなりません．
    |
    */

    'default' => env('LOG_CHANNEL', 'stack'),

    /*
    |--------------------------------------------------------------------------
    | Deprecationsログチャンネル
    |--------------------------------------------------------------------------
    |
    | このオプションは，非推奨の PHP およびライブラリ機能に関する警告を記録するための
    | ログチャンネルを制御します．これにより，今後リリースされるメジャーバージョンに
    | 対応したアプリケーションを準備することができます．
    |
    */

    'deprecations' => env('LOG_DEPRECATIONS_CHANNEL', 'null'),

    /*
    |--------------------------------------------------------------------------
    | ログチャンネル
    |--------------------------------------------------------------------------
    |
    | ここでは，アプリケーションのログチャンネルを設定することができます．
    | Laravelでは，Monolog PHPロギング・ライブラリーを使用します．これにより，
    | 様々な強力なログハンドラ/フォーマッタを利用することができます．
    |
    | Available Drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "monolog",
    |                    "custom", "stack"
    |
    */

    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['single'],
            'ignore_exceptions' => false,
        ],

        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'debug'),
        ],

        'daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'debug'),
            'days' => 14,
        ],

        'slack' => [
            'driver' => 'slack',
            'url' => env('LOG_SLACK_WEBHOOK_URL'),
            'username' => 'Laravel Log',
            'emoji' => ':boom:',
            'level' => env('LOG_LEVEL', 'critical'),
        ],

        'papertrail' => [
            'driver' => 'monolog',
            'level' => env('LOG_LEVEL', 'debug'),
            'handler' => SyslogUdpHandler::class,
            'handler_with' => [
                'host' => env('PAPERTRAIL_URL'),
                'port' => env('PAPERTRAIL_PORT'),
            ],
        ],

        'stderr' => [
            'driver' => 'monolog',
            'level' => env('LOG_LEVEL', 'debug'),
            'handler' => StreamHandler::class,
            'formatter' => env('LOG_STDERR_FORMATTER'),
            'with' => [
                'stream' => 'php://stderr',
            ],
        ],

        'syslog' => [
            'driver' => 'syslog',
            'level' => env('LOG_LEVEL', 'debug'),
        ],

        'errorlog' => [
            'driver' => 'errorlog',
            'level' => env('LOG_LEVEL', 'debug'),
        ],

        'null' => [
            'driver' => 'monolog',
            'handler' => NullHandler::class,
        ],

        'emergency' => [
            'path' => storage_path('logs/laravel.log'),
        ],
    ],

];
