<?php

namespace App\Consts\Tables;

class HubConst
{
    // テーブル名
    const NAME = 'hub';

    // 外部キーとして利用されるときのカラム名
    const USED_FOREIGN_KEY = 'hub_id';

    // カラム名
    const ID = 'id';
    const THREAD_SECONDARY_CATEGORY_ID = ThreadSecondarYCategoryConst::USED_FOREIGN_KEY;
    const USER_ID = UserConst::USED_FOREIGN_KEY;
    const _NAME = 'name';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const DELETED_AT = 'deleted_at';

    // カラム一覧
    const COLUMNS = [
        self::ID,
        self::THREAD_SECONDARY_CATEGORY_ID,
        self::USER_ID,
        self::_NAME,
        self::CREATED_AT,
        self::UPDATED_AT,
        self::DELETED_AT,
    ];
}
