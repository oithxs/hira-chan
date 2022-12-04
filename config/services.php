<?php

/**
 * @link https://laravel.com/docs/9.x/socialite
 */
return [

    /*
    |--------------------------------------------------------------------------
    | サードパーティサービス
    |--------------------------------------------------------------------------
    |
    | このファイルは Mailgun, Postmark, AWS などのサードパーティサービスの
    | 認証情報を格納するためのものです．このファイルはこの種の情報の事実上の場所を
    | 提供し，パッケージが様々なサービスの認証情報を見つけるための従来のファイルを
    | 持つことができるようにします．
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

];
