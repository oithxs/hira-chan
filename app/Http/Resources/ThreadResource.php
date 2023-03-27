<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ThreadResource extends ResourceCollection
{
    /**
     * スレッドの情報を必要最低限の要素に整形し返却する
     *
     * @param Request|null $request アクセス時のパラメータなど
     * @return array<int|string, mixed> スレッドの情報
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection->map(function (mixed $v) {
                return [
                    'id' => $v['id'],
                    'name' => $v['name'],
                    'accessCount' => $v['access_logs_count'],
                    'primaryCategoryId' => $v['thread_secondary_category']['thread_primary_category_id'],
                    'secondaryCategoryId' => $v['thread_secondary_category_id'],
                    'createdAt' => $v['created_at'],
                ];
            }),
        ];
    }
}
