<?php

namespace App\Consts\Tables;

class UserPageThemeConst
{
    // テーブル名
    const NAME = 'user_page_themes';

    // 外部キーとして利用されるときのカラム名
    const USED_FOREIGN_KEY = 'user_page_theme_id';

    // php artisan db:seed を実行後に保存されるデータ
    const DEFAULT = 'default';
    const DARK = 'dark';

    // 保存されたページテーマ一覧
    const PAGE_THEMES = [
        self::DEFAULT,
        self::DARK,
    ];
}
