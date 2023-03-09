<?php

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Http\Middleware\MirrorConfigToSubpackages;
use Filament\Pages;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

/**
 * @link https://filamentphp.com/docs/2.x/admin/appearance
 */
return [

    /*
    |--------------------------------------------------------------------------
    | フィラメントパス
    |--------------------------------------------------------------------------
    |
    | デフォルトは `admin` ですが，アプリケーションのルーティングと衝突しない，
    | 最適なものに変更することができます．
    |
    */

    'path' => env('FILAMENT_PATH', 'admin'),

    /*
    |--------------------------------------------------------------------------
    | フィラメントコアパス
    |--------------------------------------------------------------------------
    |
    | これはFilamentがコアルートとアセットをロードするために使用するパスです．
    | 他のルートと競合する場合は，変更しても構いません．
    |
    */

    'core_path' => env('FILAMENT_CORE_PATH', 'filament'),

    /*
    |--------------------------------------------------------------------------
    | フィラメントドメイン
    |--------------------------------------------------------------------------
    |
    | Filamentが有効になるべきドメインを変更することができます．
    | ドメインが空の場合，すべてのドメインが有効になります．
    |
    */

    'domain' => env('FILAMENT_DOMAIN'),

    /*
    |--------------------------------------------------------------------------
    | ホームページURL
    |--------------------------------------------------------------------------
    |
    | これは，サイドバーのヘッダーをクリックしたときにFilamentがユーザーを
    | リダイレクトするURLです．
    |
    */

    'home_url' => '/',

    /*
    |--------------------------------------------------------------------------
    | ブランド名
    |--------------------------------------------------------------------------
    |
    | ログインページとサイドバーのヘッダーに表示されます．
    |
    */

    'brand' => env('APP_NAME'),

    /*
    |--------------------------------------------------------------------------
    | 認証
    |--------------------------------------------------------------------------
    |
    | これは，Filamentが管理画面での認証を処理するために使用する設定です．
    |
    */

    'auth' => [
        'guard' => env('FILAMENT_AUTH_GUARD', 'web'),
        'pages' => [
            'login' => \Filament\Http\Livewire\Auth\Login::class,
        ],
        'email' => [
            'domain' => env('FILAMENT_AUTH_EMAIL_DOMAIN', '@example.com'),
            'verified' => (bool) env('FILAMENT_AUTH_EMAIL_VERIFIED', false),
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | ページ
    |--------------------------------------------------------------------------
    |
    | これはFilamentが自動的にページを登録する名前空間とディレクトリです．
    | また，ここにページを登録することもできます．
    |
    */

    'pages' => [
        'namespace' => 'App\\Filament\\Pages',
        'path' => app_path('Filament/Pages'),
        'register' => [
            Pages\Dashboard::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | リソース
    |--------------------------------------------------------------------------
    |
    | これは，Filamentが自動的にリソースを登録する名前空間とディレクトリです．
    | また，ここにリソースを登録することもできます．
    |
    */

    'resources' => [
        'namespace' => 'App\\Filament\\Resources',
        'path' => app_path('Filament/Resources'),
        'register' => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | ウィジェット
    |--------------------------------------------------------------------------
    |
    | これは，Filamentが自動的にダッシュボードウィジェットを登録するための名前空間と
    | ディレクトリです．ウィジェットはここから登録することもできます．
    |
    */

    'widgets' => [
        'namespace' => 'App\\Filament\\Widgets',
        'path' => app_path('Filament/Widgets'),
        'register' => [
            Widgets\AccountWidget::class,
            Widgets\FilamentInfoWidget::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | これは，Filamentが自動的にLivewireコンポーネントを登録するための
    | 名前空間とディレクトリです．
    |
    */

    'livewire' => [
        'namespace' => 'App\\Filament',
        'path' => app_path('Filament'),
    ],

    /*
    |--------------------------------------------------------------------------
    | ダークモード
    |--------------------------------------------------------------------------
    |
    | この機能を有効にすることで，ユーザーは管理画面の外観を明るいものと暗いものの
    | どちらかを選択でき，またシステムに任せることもできます．
    |
    */

    'dark_mode' => false,

    /*
    |--------------------------------------------------------------------------
    | データベース通知
    |--------------------------------------------------------------------------
    |
    | この機能を有効にすると，ユーザーは管理画面内のスライドオーバーページを開いて，
    | データベースの通知を確認することができるようになります．
    |
    */

    'database_notifications' => [
        'enabled' => false,
        'polling_interval' => '30s',
    ],

    /*
    |--------------------------------------------------------------------------
    | ブロードキャスト
    |--------------------------------------------------------------------------
    |
    | Laravel Echoの設定をアンコメントすることで，
    | 管理画面をPusher対応のWebソケットサーバーに接続することができます．
    |
    | これにより，管理画面にリアルタイムで通知を受け取ることができるようになります．
    |
    */

    'broadcasting' => [

        // 'echo' => [
        //     'broadcaster' => 'pusher',
        //     'key' => env('VITE_PUSHER_APP_KEY'),
        //     'cluster' => env('VITE_PUSHER_APP_CLUSTER'),
        //     'forceTLS' => true,
        // ],

    ],

    /*
    |--------------------------------------------------------------------------
    | レイアウト
    |--------------------------------------------------------------------------
    |
    | 管理画面の全体的なレイアウトの設定です．
    |
    | コンテンツの最大幅は `xl` から `7xl` まで設定でき，最大幅を指定しない場合は
    | `full` となります．
    |
    */

    'layout' => [
        'actions' => [
            'modal' => [
                'actions' => [
                    'alignment' => 'left',
                ],
            ],
        ],
        'forms' => [
            'actions' => [
                'alignment' => 'left',
            ],
            'have_inline_labels' => false,
        ],
        'footer' => [
            'should_show_logo' => true,
        ],
        'max_content_width' => null,
        'notifications' => [
            'vertical_alignment' => 'top',
            'alignment' => 'right',
        ],
        'sidebar' => [
            'is_collapsible_on_desktop' => false,
            'groups' => [
                'are_collapsible' => true,
            ],
            'width' => null,
            'collapsed_width' => null,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | 管理画面のページで使用されるfaviconのパスです．
    |
    */

    'favicon' => null,

    /*
    |--------------------------------------------------------------------------
    | デフォルトのアバタープロバイダー
    |--------------------------------------------------------------------------
    |
    | アバターがアップロードされていない場合，デフォルトのアバターを取得するための
    | サービスです．
    |
    */

    'default_avatar_provider' => \Filament\AvatarProviders\UiAvatarsProvider::class,

    /*
    |--------------------------------------------------------------------------
    | デフォルトのファイルシステムディスク
    |--------------------------------------------------------------------------
    |
    | これは，Filamentがメディアを置くために使用するストレージディスクです．
    | config/filesystems.php`で定義されたディスクのいずれかを使用することが
    | できます．
    |
    */

    'default_filesystem_disk' => env('FILAMENT_FILESYSTEM_DRIVER', 'public'),

    /*
    |--------------------------------------------------------------------------
    | Google Fonts
    |--------------------------------------------------------------------------
    |
    | これは，読み込むべき Google Fonts の URL です．任意のフォントを
    | 使用することができますが，`null`に設定することでGoogle Fontsを
    | 読み込まないようにすることができます．
    |
    | カスタムフォントを使用する場合は，カスタムテーマの `tailwind.config.js`
    | ファイルにもフォントファミリーを設定する必要があります．
    |
    */

    'google_fonts' => 'https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&display=swap',

    /*
    |--------------------------------------------------------------------------
    | ミドルウェア
    |--------------------------------------------------------------------------
    |
    | Filamentがリクエストを処理するために使用するミドルウェアスタックを
    | カスタマイズすることができます．
    |
    */

    'middleware' => [
        'auth' => [
            Authenticate::class,
        ],
        'base' => [
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            AuthenticateSession::class,
            ShareErrorsFromSession::class,
            VerifyCsrfToken::class,
            SubstituteBindings::class,
            DispatchServingFilamentEvent::class,
            MirrorConfigToSubpackages::class,
        ],
    ],

];
