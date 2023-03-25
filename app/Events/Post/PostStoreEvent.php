<?php

namespace App\Events\Post;

use App\Http\Resources\PostResource;
use App\Models\ThreadModel;

/**
 * スレッドに書き込みが行われた際に発生するイベント
 *
 * スレッドに追加された書き込みを返却する
 */
class PostStoreEvent extends OnThreadBrowsingEvent
{
    /**
     * 新しいイベントインスタンスを作成する
     */
    public function __construct(string $threadId, ThreadModel $post)
    {
        parent::__construct($threadId);
        $this->response = new PostResource(collect([$post]));
    }
}
