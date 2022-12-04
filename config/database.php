<?php

use Illuminate\Support\Str;

/**
 * @link https://readouble.com/laravel/9.x/ja/database.html
 */
return [

    /*
    |--------------------------------------------------------------------------
    | デフォルトのデータベース接続名
    |--------------------------------------------------------------------------
    |
    | ここでは，以下のデータベース接続のうち，すべてのデータベース作業で
    | デフォルト接続として使用するものを指定することができます．もちろん，
    | データベースライブラリを使用すれば，一度に多くの接続を使用することもできます．
    |
    */

    'default' => env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | データベース接続
    |--------------------------------------------------------------------------
    |
    | ここでは，アプリケーションに必要な各データベース接続の設定を行います．
    | もちろん，Laravelがサポートしている各データベースプラットフォームの設定例も
    | 以下に示していますので，簡単に開発することができます．
    |
    |
    | LaravelのデータベースはすべてPHPのPDO機能で処理されるので，開発を始める前に，
    | 選択した特定のデータベースのドライバがマシンにインストールされていることを
    | 確認してください．
    |
    */

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'url' => env('DATABASE_URL'),
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],

        'mysql' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'modes' => [
                // 'ONLY_FULL_GROUP_BY',
                'STRICT_TRANS_TABLES',
                'NO_ZERO_IN_DATE',
                'NO_ZERO_DATE',
                'ERROR_FOR_DIVISION_BY_ZERO',
                'NO_ENGINE_SUBSTITUTION',
            ],
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | 移行用リポジトリテーブル
    |--------------------------------------------------------------------------
    |
    | このテーブルは，アプリケーションに対してすでに実行されたすべての
    | マイグレーションを記録しています．この情報を使って，ディスク上の
    | マイグレーションのうち，実際にデータベースで実行されていないものを特定する
    | ことができます．
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redisデータベース
    |--------------------------------------------------------------------------
    |
    | Redisはオープンソースの高速かつ高度なキーバリューストアで，APCやMemcached
    | のような一般的なキーバリューシステムよりも豊富なコマンドを提供することも
    | できます．Laravelを使えば，簡単に使いこなすことができます．
    |
    */

    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_') . '_database_'),
        ],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],

        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
        ],

    ],

];
