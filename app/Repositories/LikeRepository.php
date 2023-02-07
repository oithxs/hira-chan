<?php

namespace App\Repositories;

use App\Models\Like;

class LikeRepository
{
    /**
     * 書き込みへのいいねを保存する
     *
     * @param string $foreignKey 書き込みを保存しているテーブルの外部キー名
     * @param integer $postId 書き込みのID
     * @param string $userId いいねをするユーザのID
     * @return void
     */
    public static function store(string $foreignKey, int $postId, string $userId): void
    {
        Like::create([
            $foreignKey => $postId,
            'user_id' => $userId
        ]);
    }

    /**
     * 書き込みへのいいねを削除する
     *
     * @param string $foreignKey 書き込みを保存しているテーブルの外部キー名
     * @param integer $postId 書き込みのID
     * @param string $userId いいねを削除するユーザのID
     * @return void
     */
    public static function destroy(string $foreignKey, int $postId, string $userId): void
    {
        Like::where([
            [$foreignKey, $postId],
            ['user_id', $userId],
        ])->delete();
    }

    /**
     * 対応する書き込みのいいね数を取得する
     *
     * @param string $foreignKey 書き込みを保存しているテーブルの外部キー名
     * @param integer $postId 書き込みのID
     * @return integer 書き込みのいいね数
     */
    public static function countLike(string $foreignKey, int $postId): int
    {
        return Like::where($foreignKey, $postId)->count();
    }
}
