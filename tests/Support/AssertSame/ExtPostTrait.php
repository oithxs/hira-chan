<?php

namespace Tests\Support\AssertSame;

use App\Consts\Tables\ThreadsConst;
use App\Models\Like;
use App\Models\ThreadImagePath;
use App\Models\ThreadModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

/**
 *  PostTrait を拡張し，期待する値を取得するメソッドも追加したトレイト
 */
trait ExtPostTrait
{
    use PostTrait;

    /**
     * スレッドへの書き込みを保存するテーブルの
     * 期待するデータを取得する
     *
     * @param array $args [
     *          'model' => 書き込みを保存しているテーブルのモデルクラス名（完全修飾クラス名）,
     *          'threadId' => 書き込みのスレッドID,
     *          'messageId' => 書き込みのメッセージID,
     *          'loginUserId => 書き込みを取得するユーザID（null 許容）
     *      ]
     * @return array
     */
    public function getValuesExpected(array $args): array
    {
        $model = $args['model'];
        $threadId = $args['threadId'];
        $messageId = $args['messageId'];
        $loginUserId = $args['loginUserId'] ?? '';
        $post = $this->getExpectedPost(
            $model,
            $threadId,
            $messageId
        );

        $expected = [];
        $expected['hub_id'] = $post->hub_id;
        $expected['user_id'] = $post->user_id;
        $expected['message_id'] = $post->message_id;
        $expected['message'] = $post->message;
        $expected['likes_count'] = $this->getExpectedLikesCount(
            $model,
            $post->id,
        );
        $expected['user'] = $this->getExpectedUser($post->user_id);
        $expected['thread_image_path'] = $this->getExpectedThreadImagePath(
            $model,
            $post->id
        );
        $expected['likes'] = $this->getExpectedLike(
            $model,
            $post->id,
            $loginUserId ?? ''
        );
        return $expected;
    }

    /**
     * 期待する書き込みをデータベースから取得する
     *
     * @param string $model 書き込みしたテーブルのモデル名
     * @param string $threadId 書き込み先のスレッドID
     * @param string $messageId 書き込みのメッセージID
     * @return ThreadModel
     */
    public function getExpectedPost(string $model, string $threadId, string $messageId): ThreadModel
    {
        return $model::where([
            ['hub_id', $threadId],
            ['message_id', $messageId],
        ])->first();
    }

    /**
     * 対応する likes テーブルのデータを取得する
     *
     * @param string $model 書き込みしたテーブルのモデル名
     * @param integer $postId 書き込みの主キー
     * @return Builder
     */
    public function getLikeBuilder(string $model, int $postId): Builder
    {
        return Like::where([
            [ThreadsConst::MODEL_TO_USED_FOREIGN_KEYS[$model], $postId]
        ]);
    }

    /**
     * 期待する書き込みへのいいね数を取得する
     *
     * @param string $model 書き込みしたテーブルのモデル名
     * @param integer $postId 書き込みの主キー
     * @return integer
     */
    public function getExpectedLikesCount(string $model, int $postId): int
    {
        return $this->getLikeBuilder($model, $postId)->count();
    }

    /**
     * 期待するデータベースに保存されたいいねを取得する
     *
     * @param string $model 書き込みしたテーブルのモデル名
     * @param integer $postId 書き込みの主キー
     * @param string $userId 書き込みを取得するユーザID
     * @return array
     */
    public function getExpectedLike(string $model, int $postId, string $userId): array
    {
        return $this->getLikeBuilder($model, $postId)
            ->where([[
                'user_id', $userId
            ]])->get()->toArray();
    }

    /**
     * 期待するデータベースに保存されたユーザを取得する
     *
     * @param string $userId ユーザID
     * @return array
     */
    public function getExpectedUser(string $userId): array
    {
        return User::find($userId)->toArray();
    }

    /**
     * 期待するデータベースに保存された画像の情報を取得する
     *
     * @param string $model 書き込みしたテーブルのモデル名
     * @param integer $postId 書き込みの主キー
     * @return array|null
     */
    public function getExpectedThreadImagePath(string $model, int $postId): array | null
    {
        $response = ThreadImagePath::where([
            [ThreadsConst::MODEL_TO_USED_FOREIGN_KEYS[$model], $postId],
        ])->get()->toArray();

        return $response !== []
            ? $response[count($response) - 1]
            : null;
    }
}
