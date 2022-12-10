<?php

/**
 * @link https://readouble.com/laravel/9.x/ja/configuration.html
 */
return [

    /*
    |--------------------------------------------------------------------------
    | アプリケーション名
    |--------------------------------------------------------------------------
    |
    | この値は，アプリケーションの名前です．この値は，フレームワークが
    | アプリケーションの名前を通知またはアプリケーションやパッケージが必要とする
    | 他の場所に配置する必要があるときに使用されます．
    |
    */

    'name' => env('APP_NAME', 'Laravel'),

    /*
    |--------------------------------------------------------------------------
    | アプリケーション環境
    |--------------------------------------------------------------------------
    |
    | この値は，アプリケーションが現在動作している「environment」を決定します．
    | この値は，アプリケーションが利用するさまざまなサービスをどのように
    | 設定するのが望ましいかを「.env」ファイルで設定します．
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | アプリケーションデバッグモード
    |--------------------------------------------------------------------------
    |
    | デバッグモードにすると，アプリケーションで発生したすべてのエラーについて，
    | スタックトレース付きの詳細なエラーメッセージが表示されます．無効にすると，
    | 単純な一般的なエラーページが表示されます．
    |
    */

    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | アプリケーションURL
    |--------------------------------------------------------------------------
    |
    | このURLは，Artisanコマンドラインツールを使用する際に，コンソールがURLを
    | 適切に生成するために使用されます．これをアプリケーションのルートに設定し，
    | Artisan タスクを実行するときに使用する必要があります．
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    'asset_url' => env('ASSET_URL', null),

    /*
    |--------------------------------------------------------------------------
    | アプリケーションタイムゾーン
    |--------------------------------------------------------------------------
    |
    | ここでアプリケーションのデフォルトのタイムゾーンを指定し， PHP の date および
    | date-time 関数でそれを使用するようにします．私たちは，この設定をデフォルトで
    | 適切なものに設定しました．
    |
    */

    'timezone' => 'Asia/Tokyo',

    /*
    |--------------------------------------------------------------------------
    | アプリケーションロケールの設定
    |--------------------------------------------------------------------------
    |
    | アプリケーションロケールは，翻訳サービスプロバイダで使用されるデフォルトの
    | ロケールを決定します．この値は，アプリケーションでサポートされる任意の
    | ロケールに自由に設定することができます．
    |
    */

    'locale' => 'ja',

    /*
    |--------------------------------------------------------------------------
    | アプリケーションフォールバックロケール
    |--------------------------------------------------------------------------
    |
    | フォールバックロケールは，現在のロケールが使用できないときに使用するロケールを
    | 決定する．この値は，アプリケーションで使用する言語フォルダに対応するように
    | 変更することができます．
    |
    */

    'fallback_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | フェイカー・ロケール
    |--------------------------------------------------------------------------
    |
    | このロケールは，Faker PHP ライブラリがデータベースのシード用に偽のデータを
    | 生成する際に使用されます．たとえば，ローカライズされた電話番号や住所情報などを
    | 取得する際に使用します．
    |
    */

    'faker_locale' => 'ja_JP',

    /*
    |--------------------------------------------------------------------------
    | 暗号化キー
    |--------------------------------------------------------------------------
    |
    | このキーはIlluminate暗号化サービスによって使用され，ランダムな32文字の
    | 文字列に設定する必要があります．そうしないと，これらの暗号化された文字列は
    | 安全ではありません．アプリケーションをデプロイする前にこの作業を行ってください．
    |
    */

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | オートロード・サービス・プロバイダー
    |--------------------------------------------------------------------------
    |
    | ここに掲載されているサービスプロバイダーは，お客様のアプリケーションへの
    | リクエスト時に自動的に読み込まれます．この配列に独自のサービスを追加して，
    | アプリケーションに拡張機能を付与することも可能です．
    |
    */

    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,

        /*
         * Package Service Providers...
         */

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        App\Providers\FortifyServiceProvider::class,
        App\Providers\JetstreamServiceProvider::class,

    ],

    /*
    |--------------------------------------------------------------------------
    | クラスの別名
    |--------------------------------------------------------------------------
    |
    | このクラスエイリアスの配列は，このアプリケーションの起動時に登録されます．
    | エイリアスは「lazy」ロードされるため，パフォーマンスの妨げになることは
    | ありません．
    |
    */

    'aliases' => [

        'App' => Illuminate\Support\Facades\App::class,
        'Arr' => Illuminate\Support\Arr::class,
        'Artisan' => Illuminate\Support\Facades\Artisan::class,
        'Auth' => Illuminate\Support\Facades\Auth::class,
        'Blade' => Illuminate\Support\Facades\Blade::class,
        'Broadcast' => Illuminate\Support\Facades\Broadcast::class,
        'Bus' => Illuminate\Support\Facades\Bus::class,
        'Cache' => Illuminate\Support\Facades\Cache::class,
        'Config' => Illuminate\Support\Facades\Config::class,
        'Cookie' => Illuminate\Support\Facades\Cookie::class,
        'Crypt' => Illuminate\Support\Facades\Crypt::class,
        'Date' => Illuminate\Support\Facades\Date::class,
        'DB' => Illuminate\Support\Facades\DB::class,
        'Eloquent' => Illuminate\Database\Eloquent\Model::class,
        'Event' => Illuminate\Support\Facades\Event::class,
        'File' => Illuminate\Support\Facades\File::class,
        'Gate' => Illuminate\Support\Facades\Gate::class,
        'Hash' => Illuminate\Support\Facades\Hash::class,
        'Http' => Illuminate\Support\Facades\Http::class,
        'Js' => Illuminate\Support\Js::class,
        'Lang' => Illuminate\Support\Facades\Lang::class,
        'Log' => Illuminate\Support\Facades\Log::class,
        'Mail' => Illuminate\Support\Facades\Mail::class,
        'Notification' => Illuminate\Support\Facades\Notification::class,
        'Password' => Illuminate\Support\Facades\Password::class,
        'Queue' => Illuminate\Support\Facades\Queue::class,
        'RateLimiter' => Illuminate\Support\Facades\RateLimiter::class,
        'Redirect' => Illuminate\Support\Facades\Redirect::class,
        // 'Redis' => Illuminate\Support\Facades\Redis::class,
        'Request' => Illuminate\Support\Facades\Request::class,
        'Response' => Illuminate\Support\Facades\Response::class,
        'Route' => Illuminate\Support\Facades\Route::class,
        'Schema' => Illuminate\Support\Facades\Schema::class,
        'Session' => Illuminate\Support\Facades\Session::class,
        'Storage' => Illuminate\Support\Facades\Storage::class,
        'Str' => Illuminate\Support\Str::class,
        'URL' => Illuminate\Support\Facades\URL::class,
        'Validator' => Illuminate\Support\Facades\Validator::class,
        'View' => Illuminate\Support\Facades\View::class,

    ],

];
