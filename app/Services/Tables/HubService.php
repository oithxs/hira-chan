<?php

namespace App\Services\Tables;

use App\Exceptions\ThreadNotFoundException;
use App\Models\Hub;
use App\Repositories\HubRepository;
use App\Services\HubService as ServicesHubService;
use Illuminate\Support\Collection;

class HubService
{
    private ServicesHubService $hubService;

    public function __construct(ServicesHubService $hubService)
    {
        $this->hubService = $hubService;
    }

    /**
     * 対応するスレッドを返却する
     *
     * @param string $threadId スレッドID
     * @return Hub 対応するスレッド
     * @throws ThreadNotFoundException スレッドが存在しなかった場合
     */
    public function find(string $threadId): Hub
    {
        $thread = HubRepository::find($threadId);

        if ($thread !== null) {
            return $thread;
        } else {
            throw new ThreadNotFoundException();
        }
    }

    /**
     * スレッド一覧を取得する
     *
     * リレーションシップを利用して取得
     *     thread_secondary_categorys,
     * リレーションシップを利用してカウント
     *     access_logs
     * `created_at` を基準にして降順にソート
     *
     * @return Collection スレッド一覧
     */
    public function getThreadBySCategoryAndAccessedDescendingOrder(): Collection
    {
        return $this->hubService->index();
    }
}
