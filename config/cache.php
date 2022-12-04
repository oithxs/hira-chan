<?php

use Illuminate\Support\Str;

/**
 * @link https://readouble.com/laravel/9.x/ja/cache.html
 */
return [

    /*
    |--------------------------------------------------------------------------
    | デフォルトのキャッシュストア
    |--------------------------------------------------------------------------
    |
    | このオプションは，このキャッシュライブラリの使用時に使用されるデフォルトの
    | キャッシュ接続を制御します．この接続は，キャッシュ関数を実行する際に他の接続が
    | 明示的に指定されていない場合に使用されます．
    |
    */

    'default' => env('CACHE_DRIVER', 'file'),

    /*
    |--------------------------------------------------------------------------
    | キャッシュストア
    |--------------------------------------------------------------------------
    |
    | ここでは，アプリケーションのすべてのキャッシュ「ストア」とそのドライバを
    | 定義することができます．同じキャッシュドライバに対して複数のストアを定義して，
    | キャッシュに保存されるアイテムの種類をグループ化することもできます．
    |
    | Supported drivers: "apc", "array", "database", "file",
    |         "memcached", "redis", "dynamodb", "octane", "null"
    |
    */

    'stores' => [

        'apc' => [
            'driver' => 'apc',
        ],

        'array' => [
            'driver' => 'array',
            'serialize' => false,
        ],

        'database' => [
            'driver' => 'database',
            'table' => 'cache',
            'connection' => null,
            'lock_connection' => null,
        ],

        'file' => [
            'driver' => 'file',
            'path' => storage_path('framework/cache/data'),
        ],

        'memcached' => [
            'driver' => 'memcached',
            'persistent_id' => env('MEMCACHED_PERSISTENT_ID'),
            'sasl' => [
                env('MEMCACHED_USERNAME'),
                env('MEMCACHED_PASSWORD'),
            ],
            'options' => [
                // Memcached::OPT_CONNECT_TIMEOUT => 2000,
            ],
            'servers' => [
                [
                    'host' => env('MEMCACHED_HOST', '127.0.0.1'),
                    'port' => env('MEMCACHED_PORT', 11211),
                    'weight' => 100,
                ],
            ],
        ],

        'redis' => [
            'driver' => 'redis',
            'connection' => 'cache',
            'lock_connection' => 'default',
        ],

        'dynamodb' => [
            'driver' => 'dynamodb',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
            'table' => env('DYNAMODB_CACHE_TABLE', 'cache'),
            'endpoint' => env('DYNAMODB_ENDPOINT'),
        ],

        'octane' => [
            'driver' => 'octane',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | キャッシュキーのプレフィックス
    |--------------------------------------------------------------------------
    |
    | APC や Memcached のような RAM ベースのストアを使用する場合，同じキャッシュを
    | 使用する他のアプリケーションもあるかもしれません．そこで，すべてのキーの
    | プレフィックスとして値を指定し，衝突を回避できるようにします．
    |
    */

    'prefix' => env('CACHE_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_') . '_cache'),

];
