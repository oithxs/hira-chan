<?php

namespace App\Http\Resources;

use App\Services\Support\Format;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PostResource extends ResourceCollection
{
    /**
     * スレッドへの書き込みを必要最低限の要素に整形し返却する
     * 必要になり次第要素追加
     *
     * @param Request|null $request アクセス時のパラメータなど
     * @return array<int|string, mixed> スレッドへの書き込み．必要最低限の要素に整形
     */
    public function toArray(Request $request = null): array
    {
        return [
            'data' => $this->collection->map(function (mixed $v) {
                return [
                    'messageId' => $v['message_id'],
                    'message' => $v['message'],
                    'createdAt' => Format::formatDate($v['created_at']),
                    'likesCount' => $v['likes_count'] ?? 0,
                    'user' => [
                        'name' => $v['user']['name']
                    ],
                    'threadImagePath' => isset($v['thread_image_path'])
                        ? ['imgPath' => $v['thread_image_path']['img_path']]
                        : null,
                    'onLike' => count($v['likes']) !== 0
                        ? true
                        : false
                ];
            }),
        ];
    }
}
