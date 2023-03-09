<?php

namespace App\Repositories;

use App\Models\JobHuntingThread;

class JobHuntingThreadRepository
{
    /**
     * テーブル名を取得する
     *
     * @return string テーブル名
     */
    public static function getTableName(): string
    {
        return JobHuntingThread::make()->getTable();
    }
}
