<?php

namespace App\Consts\Tables;

class ContactTypeConst
{
    // テーブル名
    const NAME = 'contact_types';

    // 外部キーとして使用されるときのカラム名
    const USED_FOREIGN_KEY = 'contact_type_id';

    // php artisan db:seed を実行後に保存されるデータ
    const OFFENSIVE_CONTENT = '不快なコンテンツ';
    const HARASSMENT_BULLYING = '嫌がらせ，いじめ';
    const INFRINGEMENT_OF_RIGHTS = '権利の侵害';
    const SPAM_OR_MISLEADING_CONTENT = 'スパムまたは誤解を招く内容';
    const BUGS_VULNERABILITIES = '掲示板サイトのバグ・脆弱性';
    const OTHER = 'その他';

    // 保存された報告・問い合わせのタイプ
    const CONTACT_TYPES = [
        self::OFFENSIVE_CONTENT,
        self::HARASSMENT_BULLYING,
        self::INFRINGEMENT_OF_RIGHTS,
        self::SPAM_OR_MISLEADING_CONTENT,
        self::BUGS_VULNERABILITIES,
        self::OTHER,
    ];
}
