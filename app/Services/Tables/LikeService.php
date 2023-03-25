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
    public function addLikeToPost(string $threadId, string $messageId, string $userId): ThreadModel
    {
        $model = $this->threadService->threadIdToModel($threadId);
        $foreignKey = $this->threadService->threadIdToForeignKey($threadId);
        $post = $this->postService->find($model, $threadId, $messageId);

        // 書き込みにいいねをする
        LikeRepository::store($foreignKey, $post->id, $userId);

        return $post;
    }
}
