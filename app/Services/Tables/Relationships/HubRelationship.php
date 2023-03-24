<?php

namespace App\Services\Tables\Relationships;

use App\Exceptions\ThreadNotFoundException;
use App\Models\ThreadPrimaryCategory;
use App\Models\ThreadSecondaryCategory;
use App\Repositories\HubRepository;

class HubRelationship
{
    /**
     * 該当スレッドの詳細カテゴリを取得する
     *
     * @param string $threadId スレッドID
     * @return ThreadSecondaryCategory スレッドIDに対応する詳細カテゴリ
     * @throws ThreadNotFoundException スレッドが存在しなかった場合
     */
    public function getThreadSecondaryCategory(string $threadId): ThreadSecondaryCategory
    {
        $thread = HubRepository::find($threadId);

        if ($thread !== null) {
            return $thread->thread_secondary_category;
        } else {
            throw new ThreadNotFoundException();
        }
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
