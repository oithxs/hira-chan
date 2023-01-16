<?php

namespace App\Consts\Tables;

class ThreadPrimaryCategoryConst
{
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
