<?php

namespace App\Repositories;

use App\Models\ThreadPrimaryCategory;

class ThreadPrimaryCategoryRepository
{
    /**
     * `id` から対象のデータを取得する
     *
     * @param integer $id
     * @return ThreadPrimaryCategory|null
     */
    public static function find(int $id): ThreadPrimaryCategory | null
    {
        return ThreadPrimaryCategory::find($id);
    }

    /**
     * `id` から対象カテゴリの名前を取得する
     *
     * @param integer $id
     * @return string
     */
    public static function getName(int $id): string | null
    {
        return self::find($id)->name ?? null;
    }
}
