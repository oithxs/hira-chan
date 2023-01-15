<?php

namespace App\Repositories;

use App\Models\CollegeYearThread;

class CollegeYearThreadRepository
{
    /**
     * テーブル名を取得する
     *
     * @return string
     */
    public static function getTableName(): string
    {
        return CollegeYearThread::make()->getTable();
    }
}