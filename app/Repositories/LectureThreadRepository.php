<?php

namespace App\Repositories;

use App\Models\LectureThread;

class LectureThreadRepository
{
    /**
     * テーブル名を取得する
     *
     * @return string
     */
    public static function getTableName(): string
    {
        return LectureThread::make()->getTable();
    }
}
