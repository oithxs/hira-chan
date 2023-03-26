<?php

namespace App\Events\ThreadBrowsing;

use App\Http\Resources\PostLikeResource;
use App\Models\ThreadModel;

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
