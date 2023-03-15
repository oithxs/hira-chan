<?php

namespace App\Services;

use App\Models\ThreadSecondaryCategory;
use App\Repositories\ThreadSecondaryCategoryRepository;
use Illuminate\Database\Eloquent\Collection;

class ThreadSecondaryCategoryService
{
    /**
     * 大枠カテゴリ一覧を取得する
     *
     * @return Collection 大枠カテゴリ一覧
     */
    public function index(): Collection
    {
        return ThreadSecondaryCategoryRepository::get(['thread_primary_category']);
    }

    /**
     * 対応する大枠カテゴリを取得する
     *
     * @return ThreadSecondaryCategory 対応する大枠カテゴリ
     */
    public function show(int $id): ThreadSecondaryCategory
    {
        return ThreadSecondaryCategoryRepository::find($id, ['thread_primary_category']);
    }
}
