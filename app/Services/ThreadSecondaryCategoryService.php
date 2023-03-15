<?php

namespace App\Services;

use App\Models\ThreadSecondaryCategory;
use App\Repositories\ThreadSecondaryCategoryRepository;
use Illuminate\Database\Eloquent\Collection;

class ThreadSecondaryCategoryService
{
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
