<?php

namespace App\Services;

use App\Models\ThreadSecondaryCategory;
use App\Repositories\ThreadSecondaryCategoryRepository;
use Illuminate\Database\Eloquent\Collection;

class ThreadSecondaryCategoryService
{
    /**
     * 詳細カテゴリ一覧を取得する
     *
     * @return Collection 詳細カテゴリ一覧
     */
    public function index(): Collection
    {
        return ThreadSecondaryCategoryRepository::get(['thread_primary_category']);
    }

    /**
     * 対応する詳細カテゴリを取得する
     *
     * @return ThreadSecondaryCategory 対応する詳細カテゴリ
     */
    public function show(int $id): ThreadSecondaryCategory
    {
        return ThreadSecondaryCategoryRepository::find($id, ['thread_primary_category']);
    }
}
