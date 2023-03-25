<?php

namespace App\Repositories;

use App\Models\ThreadModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class PostRepository
{
    const GET_POST_WITH_COUNT = 'likes';

    public static function getPostWith(string $userId): array
    {
        return [
            'user',
            'thread_image_path',
            'likes' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }
        ];
    }

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
     * 書き込みを取得する
     *
     * @param string $model 書き込みを取得したいモデルクラス
     * @param string $threadId 書き込みを取得したいスレッドのID
     * @param integer $messageId 書き込みを取得したいメッセージのID
     * @return ThreadModel|null 書き込み
     */
    public static function find(string $model, string $threadId, int $messageId): ThreadModel | null
    {
        return  self::baseBuilder(model: $model, withCount: self::GET_POST_WITH_COUNT)
            ->where([
                ['hub_id', $threadId],
                ['message_id', $messageId]
            ])->first();
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
        return self::baseBuilder($model, self::getPostWith($userId), self::GET_POST_WITH_COUNT)
            ->where('hub_id', $threadId)
            ->get();
    }

    /**
     * スレッドに書き込みを行う
     *
     * @param string $model 書き込みを保存するモデル名
     * @param string $threadId 書き込むスレッドのID
     * @param string $userId 書き込むユーザのID
     * @param string $message 書き込む内容
     * @return ThreadModel スレッド（テーブル）へ保存した書き込み
     */
    public static function insert(string $model, string $threadId, string $userId, string $message): ThreadModel
    {
        return $model::create([
            'hub_id' => $threadId,
            'user_id' => $userId,
            'message_id' => self::getMaxMessageId($model, $threadId) + 1 ?? 0,
            'message' => $message
        ]);
    }

    /**
     * スレッドの最大 `message_id` を取得する
     *
     * @param string $model スレッドを保存しているモデルクラスの完全修飾クラス名
     * @param string $threadId スレッドID
     * @return integer|null スレッドの最大メッセージID
     */
    public static function getMaxMessageId(string $model, string $threadId): int | null
    {
        return $model::where('hub_id', '=', $threadId)->max('message_id');
    }
}
