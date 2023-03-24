<?php

namespace App\Services\Tables;

use App\Repositories\PostRepository;
use App\Services\Tables\Relationships\HubRelationship;
use App\Services\ThreadService;
use Illuminate\Support\Collection;

class PostService
{
    private ThreadService $threadService;

    private HubRelationship $hubRelationship;

    public function __construct(ThreadService $threadService, HubRelationship $hubRelationship)
    {
        $this->threadService = $threadService;
        $this->hubRelationship = $hubRelationship;
    }

    /**
     * 指定されたスレッドの書き込み一覧を取得する
     *
     * @param string $threadId スレッドID
     * @param string $userId ログインしているユーザID
     * @return Collection 指定された書き込み一覧
     */
    public function getPostWithUserImageAndLikes(string $threadId, string $userId): Collection
    {
        $threadPrimaryCategoryName = $this
            ->hubRelationship->getThreadPrimaryCategory($threadId)->name;
        $model = $this->threadService->getThreadClassName($threadPrimaryCategoryName);

        return PostRepository::getPostWithUserImageAndLikes($model, $threadId, $userId);
    }
}
