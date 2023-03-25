<?php

namespace App\Events\ThreadBrowsing;

use App\Http\Resources\PostLikeResource;
use App\Models\ThreadModel;

/**
 * 書き込みにいいねがされた際に発生するイベント
 *
 * 書き込みにされたいいね数を返却する
 */
trait LikeToPost
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
