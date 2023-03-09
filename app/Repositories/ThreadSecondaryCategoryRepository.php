<?php

namespace App\Repositories;

use App\Models\ThreadSecondaryCategory;

class ThreadSecondaryCategoryRepository
{
    /**
     * 詳細カテゴリ名からIDを取得する
     *
     * @param string $threadSecondaryCategoryName 詳細カテゴリ名
     * @return integer|null 詳細カテゴリのID
     */
    public static function nameToId(string $threadSecondaryCategoryName): int | null
    {
        return ThreadSecondaryCategory::where([
            ['name', $threadSecondaryCategoryName]
        ])->first()->id ?? null;
    }
}
