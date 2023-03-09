<?php

namespace App\Consts\Tables;

class AccessLogConst
{
    // テーブル名
    const NAME = 'access_logs';

    // 外部キーとして利用されるときのカラム名
    const USED_FOREIGN_KEY = 'access_log_id';
}
