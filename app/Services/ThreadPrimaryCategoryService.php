<?php

namespace App\Services;

use App\Repositories\ThreadPrimaryCategoryRepository;
use Illuminate\Database\Eloquent\Collection;

class ThreadPrimaryCategoryService
{
    /**
     * 大枠カテゴリ一覧を取得する
     *
     * @return Collection 大枠カテゴリ一覧
     */
    public function index(): Collection
    {
        return ThreadPrimaryCategoryRepository::get(['thread_secondary_categorys']);
    }
}
