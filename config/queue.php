<?php

/**
 * @link https://readouble.com/laravel/9.x/ja/queues.html
 */
return [

    /*
    |--------------------------------------------------------------------------
    | デフォルトのキュー接続名
    |--------------------------------------------------------------------------
    |
    | LaravelのキューAPIは，単一のAPIを通じて様々なバックエンドをサポートしており，
    | どのバックエンドにも同じ構文で便利にアクセスすることができます．ここでは，
    | デフォルトの接続を定義することができます．
    |
    */

    'default' => env('QUEUE_CONNECTION', 'sync'),

    /*
    |--------------------------------------------------------------------------
    | キューコネクション
    |--------------------------------------------------------------------------
    |
    | ここでは，アプリケーションで使用される各サーバーの接続情報を設定することが
    | できます．Laravelに同梱されている各バックエンドには，デフォルトの設定が
    | 追加されています．自由に追加することができます．
    |
    | Drivers: "sync", "database", "beanstalkd", "sqs", "redis", "null"
    |
    */

    'connections' => [

        'sync' => [
            'driver' => 'sync',
        ],

        'database' => [
            'driver' => 'database',
            'table' => 'jobs',
            'queue' => 'default',
            'retry_after' => 90,
            'after_commit' => false,
        ],

        'beanstalkd' => [
            'driver' => 'beanstalkd',
            'host' => 'localhost',
            'queue' => 'default',
            'retry_after' => 90,
            'block_for' => 0,
            'after_commit' => false,
        ],

        'sqs' => [
            'driver' => 'sqs',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'prefix' => env('SQS_PREFIX', 'https://sqs.us-east-1.amazonaws.com/your-account-id'),
            'queue' => env('SQS_QUEUE', 'default'),
            'suffix' => env('SQS_SUFFIX'),
            'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
            'after_commit' => false,
        ],

        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
            'queue' => env('REDIS_QUEUE', 'default'),
            'retry_after' => 90,
            'block_for' => null,
            'after_commit' => false,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | 失敗したキュージョブ
    |--------------------------------------------------------------------------
    |
    | これらのオプションは，失敗したジョブを保存するためにどのデータベースと
    | テーブルを使用するかを制御できるように，失敗したキュー・ジョブのログの動作を
    | 設定します．これらのオプションは，任意のデータベースとテーブルに変更することが
    | できます．
    |
    */

    'failed' => [
        'driver' => env('QUEUE_FAILED_DRIVER', 'database-uuids'),
        'database' => env('DB_CONNECTION', 'mysql'),
        'table' => 'failed_jobs',
    ],

];
