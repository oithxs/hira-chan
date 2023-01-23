<?php

namespace App\Consts\Tables;

class PasswordResetConst
{
    // テーブル名
    const NAME = 'password_resets';

    // 外部キーとして利用されるときのカラム名
    const USED_FOREIGN_KEY = 'password_reset_id';
}
