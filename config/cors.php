<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) の設定
    |--------------------------------------------------------------------------
    |
    | ここでは，クロスオリジンリソース共有または「CORS」についての設定を行うことが
    | できます．これは，Webブラウザーで実行できるクロスオリジンオペレーションを
    | 決定するものです．これらの設定は，必要に応じて自由に変更することができます．
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => ['*'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];
