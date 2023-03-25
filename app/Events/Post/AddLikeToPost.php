<?php

namespace App\Events\Post;

use App\Http\Resources\PostLikeResource;
use App\Models\ThreadModel;

/**
 * 書き込みにいいねがされた際に発生するイベント
 *
 * 書き込みにされたいいね数を返却する
 */
class AddLikeToPost extends OnThreadBrowsingEvent
{
    /**
     * 新しいイベントインスタンスを作成する
     */
    public function __construct(string $threadId, ThreadModel $post)
    {
        parent::__construct($threadId);
        $this->response = new PostLikeResource(collect($post));
    }
}
