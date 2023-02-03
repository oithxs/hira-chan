<?php

namespace App\Consts\Tables;

class SessionConst
{
    // テーブル名
    const NAME = 'sessions';

    // 外部キーとして利用されるときのカラム名
    const USED_FOREIGN_KEY = 'session_id';
}
