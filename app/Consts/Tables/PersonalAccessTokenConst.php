<?php

namespace App\Consts\Tables;

class PersonalAccessTokenConst
{
    // テーブル名
    const NAME = 'personal_access_tokens';

    // 外部キーとして利用されるときのカラム名
    const USED_FOREIGN_KEY = 'personal_access_token_id';
}
