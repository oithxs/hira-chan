<?php

namespace App\Consts\Tables;

class ThreadPrimaryCategoryConst
{
    // テーブル名
    const NAME = 'thread_primary_categorys';

    // 外部キーとして利用されるときのカラム名
    const USED_FOREIGN_KEY = 'thread_primary_category_id';

    // カラム名
    const ID = 'id';
    const _NAME = 'name';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    // カラム一覧
    const COLUMNS = [
        self::ID,
        self::_NAME,
        self::CREATED_AT,
        self::UPDATED_AT,
    ];

    // php artisan db:seed を実行後に保存されるデータ
    const CLUB = '部活';
    const COLLEGE_YEAR = '学年';
    const DEPARTMENT = '学科';
    const JOB_HUNTING = '就職';
    const LECTURE = '授業';

    // 保存されたカテゴリ名一覧
    const PRIMARY_CATEGORYS = [
        self::CLUB,
        self::COLLEGE_YEAR,
        self::DEPARTMENT,
        self::JOB_HUNTING,
        self::LECTURE,
    ];
}
