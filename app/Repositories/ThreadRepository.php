<?php

namespace App\Repositories;

use App\Models\Hub;
use App\Models\ThreadModel;
use App\Models\ThreadPrimaryCategory;
use App\Models\ThreadSecondaryCategory;
use Illuminate\Support\Collection;

class ThreadRepository
{
    /**
     * スレッドの書き込みを取得する
     *
     * @param string $threadModelFQCN 書き込みを取得するモデルクラスまでの完全修飾クラス名
     * @param string $threadId 取得するスレッドのID
     * @param string $userId ログインしているユーザID
     * @param integer $preMaxMessageId 前回取得したメッセージIDの最大値
     * @return Collection 対応するスレッドへの書き込み一覧．書き込みに対する「いいね」や「ユーザ」，「画像の情報」含む
     */
    public static function show(
        string $threadModelFQCN,
        string $threadId,
        string $userId,
        int $preMaxMessageId
    ): Collection {
        return $threadModelFQCN::with([
            'user',
            'thread_image_path',
            'likes' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }
        ])
            ->withCount('likes')
            ->where([
                ['hub_id', $threadId],
                ['message_id', '>', $preMaxMessageId]
            ])
            ->get();
    }

    /**
     * スレッドに書き込みを行う
     *
     * @param string $threadClassName 書き込みを保存するモデルクラスまでの完全修飾クラス名
     * @param string $threadId 書き込むスレッドのID
     * @param string $userId 書き込むユーザのID
     * @param string $message 書き込む内容
     * @return ThreadModel スレッド（テーブル）へ保存した書き込み
     */
    public static function store(
        string $threadClassName,
        string $threadId,
        string $userId,
        string $message
    ): ThreadModel {
        return $threadClassName::create([
            'hub_id' => $threadId,
            'user_id' => $userId,
            'message_id' => self::getMaxMessageId($threadClassName, $threadId) + 1 ?? 0,
            'message' => $message
        ]);
    }

    /**
     * スレッドの最大 `message_id` を取得する
     *
     * @param string $threadClassName スレッドを保存しているモデルクラスの完全修飾クラス名
     * @param string $threadId スレッドID
     * @return integer|null スレッドの最大メッセージID
     */
    public static function getMaxMessageId(
        string $threadClassName,
        string $threadId
    ): int | null {
        return $threadClassName::where('hub_id', '=', $threadId)->max('message_id');
    }

    /**
     * 書き込みの `id` を取得する
     *
     * @param ThreadModel $post スレッドへの書き込み
     * @return string 書き込みの`id`
     */
    public static function getId(ThreadModel $post): string
    {
        return $post->id;
    }

    /**
     * 書き込みの `hub_id` を取得する
     *
     * @param ThreadModel $post スレッドへの書き込み
     * @return string 書き込みの`hub_id`
     */
    public static function getHubId(ThreadModel $post): string
    {
        return $post->hub_id;
    }

    /**
     * 書き込みからスレッドを取得する
     *
     * @param ThreadModel $post　スレッドへの書き込み
     * @return Hub 書き込んだスレッド
     */
    public static function postToHub(ThreadModel $post): Hub
    {
        return $post->hub;
    }

    /**
     * 書き込みから詳細カテゴリを取得する
     *
     * @param ThreadModel $post スレッドへの書き込み
     * @return ThreadSecondaryCategory 書き込んだスレッドが属する詳細カテゴリ
     */
    public static function postToThreadSecondaryCategory(ThreadModel $post): ThreadSecondaryCategory
    {
        return self::postToHub($post)->thread_secondary_category;
    }

    /**
     * 書き込みから大枠カテゴリを取得する
     *
     * @param ThreadModel $post スレッドへの書き込み
     * @return ThreadPrimaryCategory 書き込んだスレッドが属する大枠カテゴリ
     */
    public static function postToThreadPrimaryCategory(ThreadModel $post): ThreadPrimaryCategory
    {
        return self::postToThreadSecondaryCategory($post)->thread_primary_category;
    }

    /**
     * 書き込みから大枠カテゴリ名を取得する
     *
     * @param ThreadModel $post スレッドへの書き込み
     * @return string 書き込んだスレッドが属する大枠カテゴリの名前
     */
    public static function postToThreadPrimaryCategoryName(ThreadModel $post): string
    {
        return self::postToThreadPrimaryCategory($post)->name;
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
        return $model::where([
            ['hub_id', $threadId],
            ['message_id', $messageId]
        ])->first();
    }

    /**
     * 書き込みのIDを取得する
     *
     * @param string $model 書き込みを取得したいモデルクラス
     * @param string $threadId 書き込みを取得したいスレッドのID
     * @param integer $messageId 書き込みを取得したいメッセージのID
     * @return integer|null 書き込み
     */
    public static function findId(string $model, string $threadId, int $messageId): int | null
    {
        return self::find($model, $threadId, $messageId)->id ?? null;
    }
}
