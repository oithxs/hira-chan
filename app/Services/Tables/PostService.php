<?php

namespace App\Services\Tables;

use App\Exceptions\PostNotFoundException;
use App\Models\ThreadModel;
use App\Repositories\PostRepository;
use App\Services\PostService as PrePostService;
use App\Services\Tables\Relationships\HubRelationship;
use App\Services\ThreadService;
use Illuminate\Support\Collection;

class PostService
{
    private ThreadService $threadService;

    private HubRelationship $hubRelationship;

    private PrePostService $prePostService;

    public function __construct(ThreadService $threadService, HubRelationship $hubRelationship, PrePostService $prePostService)
    {
        $this->threadService = $threadService;
        $this->hubRelationship = $hubRelationship;
        $this->prePostService = $prePostService;
    }

    /**
     * 対応する書き込みを取得する
     *
     * @param string $model 書き込みが保存されているテーブルのモデル名
     * @param string $threadId スレッドID
     * @param integer $messageId メッセージID
     * @return ThreadModel 対応する書き込み
     * @throws PostNotFoundException 対応する書き込みが存在しない場合
     */
    public static function find(string $model, string $threadId, int $messageId): ThreadModel
    {
        $post = PostRepository::find($model, $threadId, $messageId);

        if ($post !== null) {
            return $post;
        } else {
            throw new PostNotFoundException();
        }
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

    /**
     * スレッドに書き込みを行う
     *
     * @param string $threadId 書き込むスレッドのID
     * @param string $userId スレッドに書き込むユーザのID
     * @param string $message スレッドに書き込む内容
     * @param string|null $reply 書き込みの返信先`message_id`
     * @return ThreadModel スレッド（テーブル）へ保存した書き込み
     */
    public function store(
        string $threadId,
        string $userId,
        string $message,
        string | null $reply
    ): ThreadModel {
        $threadPrimaryCategoryName = $this
            ->hubRelationship->getThreadPrimaryCategory($threadId)->name;
        $model = $this->threadService->getThreadClassName($threadPrimaryCategoryName);

        return PostRepository::insert(
            $model,
            $threadId,
            $userId,
            $this->prePostService->messageProcessing($message, $reply)
        );
    }
}
