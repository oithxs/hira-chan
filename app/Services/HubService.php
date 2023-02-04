<?php

namespace App\Services;

use App\Repositories\HubRepository;
use App\Repositories\ThreadSecondaryCategoryRepository;

class HubService
{
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
