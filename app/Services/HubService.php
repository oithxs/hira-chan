<?php

namespace App\Services;

use App\Repositories\HubRepository;
use App\Repositories\ThreadSecondaryCategoryRepository;
use Illuminate\Database\Eloquent\Collection;

class HubService
{
    /**
     * スレッド一覧を取得する
     *
     * @return Collection スレッド一覧
     */
    public function index(): Collection
    {
        return HubRepository::get(
            with: ['thread_secondary_category'],
            withCount: ['access_logs'],
            orderBy: ['created_at', 'desc']
        );
    }

    /**
     * スレッドを作成する
     *
     * @param string $threadSecondaryCategoryName 作成するスレッドが属する詳細カテゴリ名
     * @param string $userId スレッドを作成するユーザのID
     * @param string $threadName 作成するスレッド名
     * @return void
     */
    public function store(
        string $threadSecondaryCategoryName,
        string $userId,
        string $threadName
    ): void {
        HubRepository::store(
            ThreadSecondaryCategoryRepository::nameToId($threadSecondaryCategoryName),
            $userId,
            $threadName
        );
    }
}
