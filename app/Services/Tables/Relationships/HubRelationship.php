<?php

namespace App\Services\Tables\Relationships;

use App\Models\ThreadPrimaryCategory;
use App\Models\ThreadSecondaryCategory;
use App\Services\Tables\HubService;

class HubRelationship
{
    private HubService $hubService;

    public function __construct(HubService $hubService)
    {
        $this->hubService = $hubService;
    }

    /**
     * 該当スレッドの詳細カテゴリを取得する
     *
     * @param string $threadId スレッドID
     * @return ThreadSecondaryCategory スレッドIDに対応する詳細カテゴリ
     */
    public function getThreadSecondaryCategory(string $threadId): ThreadSecondaryCategory
    {
        return $this->hubService->find($threadId)->thread_secondary_category;
    }

    /**
     * 該当スレッドの大枠カテゴリを取得する
     *
     * @param string $threadId スレッドID
     * @return ThreadPrimaryCategory スレッドIDに対応する大枠カテゴリ
     */
    public function getThreadPrimaryCategory(string $threadId): ThreadPrimaryCategory
    {
        return $this->getThreadSecondaryCategory($threadId)->thread_primary_category;
    }
}
