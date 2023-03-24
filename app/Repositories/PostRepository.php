<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class PostRepository
{
    /**
     * 書き込みが保存されているテーブルからデータを取得する際のリレーションシップを操作する
     *
     * @param array|string $with リレーションシップを利用して取得するデータ
     * @param array|string $withCount カウントする関係のあるテーブルのレコード
     * @return Builder
     */
    public static function baseBuilder(string $model, array | string $with = [], array | string $withCount = []): Builder
    {
        return $model::with($with)->withCount($withCount);
    }

    /**
     * 指定されたスレッドの書き込み一覧を取得する
     *
     * リレーションシップを利用して取得
     *     users,
     *     thread_image_path,
     *     likes (if: ログインしているユーザがしたいいね)
     * リレーションシップを利用してカウント
     *     likes
     *
     * @param string $model 書き込みが保存されているモデル名
     * @param string $threadId スレッドID
     * @param string $userId ログインしているユーザID
     * @return Collection 指定された書き込み一覧
     */
    public static function getPostWithUserImageAndLikes(string $model, string $threadId, string $userId): Collection
    {
        $with = [
            'user',
            'thread_image_path',
            'likes' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }
        ];
        $withCount = 'likes';

        return self::baseBuilder($model, $with, $withCount)
            ->where('hub_id', $threadId)
            ->get();
    }
}
