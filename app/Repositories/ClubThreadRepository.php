<?php

namespace App\Repositories;

use App\Models\ClubThread;

class ClubThreadRepository
{
    /**
     * テーブル名を取得する
     *
     * @return string テーブル名
     */
    public static function getTableName(): string
    {
        return ClubThread::make()->getTable();
    }
}
