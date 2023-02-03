<?php

namespace App\Repositories;

use App\Models\Hub;
use App\Models\ThreadPrimaryCategory;
use App\Models\ThreadSecondaryCategory;

class HubRepository
{
    /**
     * id からスレッドを取得する
     *
     * @param string $threadId スレッドID
     * @return Hub|null スレッドIDに対応するスレッド
     */
    public static function find(string $threadId): Hub | null
    {
        return Hub::find($threadId);
    }

    /**
     * id から該当スレッドの詳細カテゴリを取得する
     *
     * @param string $threadId スレッドID
     * @return ThreadSecondaryCategory スレッドIDに対応する詳細カテゴリ
     */
    public static function getThreadSecondaryCategory(string $threadId): ThreadSecondaryCategory
    {
        return self::find($threadId)->thread_secondary_category;
    }

    /**
     * id から該当スレッドの大枠カテゴリを取得する
     *
     * @param string $threadId スレッドID
     * @return ThreadPrimaryCategory スレッドIDに対応する大枠カテゴリ
     */
    public static function getThreadPrimaryCategory(string $threadId): ThreadPrimaryCategory
    {
        return self::getThreadSecondaryCategory($threadId)->thread_primary_category;
    }

    /**
     * id から該当スレッドの大枠カテゴリの名前を取得する
     *
     * @param string $threadId スレッドID
     * @return string スレッドIDに対応する大枠カテゴリ名
     */
    public static function getThreadPrimaryCategoryName(string $threadId): string
    {
        return self::getThreadPrimaryCategory($threadId)->name;
    }
}
