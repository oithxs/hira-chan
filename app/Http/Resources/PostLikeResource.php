<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PostLikeResource extends ResourceCollection
{
    /**
     * 書き込みにされたいいねの情報を必要最低限の要素に整形し返却する
     *
     * @param Request|null $request アクセス時のパラメータなど
     * @return array<int|string, mixed> 書き込みにされたいいね．必要最低限の要素に整形
     */
    public function toArray(Request $request = null): array
    {
        return [
            'data' => [
                'messageId' => $this->collection["message_id"],
                'likesCount' => $this->collection["likes_count"] ?? 0,
            ],
        ];
    }
}
