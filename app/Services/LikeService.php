<?php

namespace App\Services;

use App\Repositories\LikeRepository;
use App\Repositories\ThreadRepository;

class LikeService
{
    private ThreadService $threadService;

    /**
     * @var string|null 外部キー名
     */
    private string | null $foreignKey;

    /**
     * @var integer|null 書き込みのID
     */
    private int | null $postId;

    public function __construct()
    {
        $this->threadService = new ThreadService;
        $this->foreignKey = null;
        $this->postId = null;
    }

    /**
     * 書き込みにいいねをする
     *
     * @param string $threadId いいねをする書き込みのスレッドID
     * @param string $messageId いいねをする書き込みのメッセージID
     * @param string $userId いいねをするユーザID
     * @return void
     */
    public function store(string $threadId, string $messageId, string $userId): void
    {
        $this->foreignKey = $this->threadService->threadIdToForeignKey($threadId);
        $this->postId = ThreadRepository::findId(
            $this->threadService->threadIdToModel($threadId),
            $threadId,
            $messageId
        );
        LikeRepository::store(
            $this->foreignKey,
            $this->postId,
            $userId
        );
    }

    /**
     * 指定された書き込みにされたいいね数をカウントする
     *
     * @param string|null $foreignKey 書き込みを保存しているテーブルの外部キー名
     * @param integer|null $postId 書き込みのID
     * @return integer 書き込みのいいね数
     */
    public function countLike(string $foreignKey = null, int $postId = null): int
    {
        return LikeRepository::countLike(
            $foreignKey ?? $this->foreignKey,
            $postId ?? $this->postId
        );
    }
}
