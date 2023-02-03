<?php

namespace App\Consts\Tables;

class MigrationConst
{
    // カラム名
    const NAME = 'migrations';

    // 外部キーとして利用されるときのカラム名
    const USED_FOREIGN_KEY = 'migration_id';
}
