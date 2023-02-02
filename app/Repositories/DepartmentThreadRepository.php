<?php

namespace App\Repositories;

use App\Models\DepartmentThread;

class DepartmentThreadRepository
{
    /**
     * テーブル名を取得する
     *
     * @return string テーブル名
     */
    public static function getTableName(): string
    {
        return DepartmentThread::make()->getTable();
    }
}
