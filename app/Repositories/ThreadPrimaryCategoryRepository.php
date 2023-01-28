<?php

namespace App\Repositories;

use App\Models\ThreadPrimaryCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    /**
     * `name` から対象のデータを取得する
     *
     * @param string $primaryCategoryName 大枠カテゴリ名
     * @return Builder
     */
    public static function getThreadPrimaryCategoryBuilder(string $primaryCategoryName): Builder
    {
        return ThreadPrimaryCategory::where('name', $primaryCategoryName);
    }

    /**
     * `name` から対応する詳細カテゴリのデータを取得する
     *
     * @param string $primaryCategoryName
     * @return HasMany
     */
    public static function getThreadSecondaryCategoryHasMany(string $primaryCategoryName): HasMany
    {
        return self::getThreadPrimaryCategoryBuilder($primaryCategoryName)
            ->first()
            ->thread_secondary_categorys();
    }
}
