<?php

namespace App\Services\Tables;

use App\Models\ThreadModel;
use App\Repositories\LikeRepository;
use App\Services\ThreadService;

class LikeService
{
    private ThreadService $threadService;

    private PostService $postService;

    public function __construct(ThreadService $threadService, PostService $postService)
    {
        $this->threadService = $threadService;
        $this->postService = $postService;
    }

    /**
     * 書き込みにいいねをする
     *
     * @param string $threadId いいねをする書き込みのスレッドID
     * @param string $messageId いいねをする書き込みのメッセージID
     * @param string $userId いいねをするユーザID
     * @return ThreadModel いいねをした書き込み
     */
    public function addLikeOnPost(string $threadId, string $messageId, string $userId): ThreadModel
    {
        $model = $this->threadService->threadIdToModel($threadId);
        $foreignKey = $this->threadService->threadIdToForeignKey($threadId);
        $post = $this->postService->find($model, $threadId, $messageId);

        // 書き込みにいいねをする
        LikeRepository::store($foreignKey, $post->id, $userId);

        return $post;
    }

    /**
     * 書き込みのいいねを削除する
     *
     * @param string $threadId 削除する，いいねがついた書き込みのスレッドID
     * @param string $messageId 削除する，いいねがついた書き込みのメッセージID
     * @param string $userId 削除するいいねをつけたユーザID
     * @return ThreadModel いいねを取り消した書き込み
     */
    public function deleteLikeOnPost(string $threadId, string $messageId, string $userId): ThreadModel
    {
        $model = $this->threadService->threadIdToModel($threadId);
        $foreignKey = $this->threadService->threadIdToForeignKey($threadId);
        $post = $this->postService->find($model, $threadId, $messageId);

        // 書き込みのいいねを取り消す
        LikeRepository::destroy($foreignKey, $post->id, $userId);

        return $post;
    }
}
