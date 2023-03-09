<?php

namespace Database\Factories;

use App\Consts\Tables\ThreadsConst;
use App\Models\Hub;
use App\Models\User;
use App\Repositories\ThreadPrimaryCategoryRepository;
use App\Repositories\ThreadRepository;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ThreadFactory extends Factory
{
    /**
     * モデルのデフォルトの状態を定義する．
     *
     * @link https://readouble.com/laravel/9.x/ja/database-testing.html
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $thread = Hub::factory()->create([
            'thread_secondary_category_id' => random_int(
                ThreadPrimaryCategoryRepository::getThreadSecondaryCategoryHasMany(
                    ThreadsConst::MODEL_TO_CATEGORYS[$this->model]
                )
                    ->first()
                    ->id,
                ThreadPrimaryCategoryRepository::getThreadSecondaryCategoryHasMany(
                    ThreadsConst::MODEL_TO_CATEGORYS[$this->model]
                )
                    ->orderByDesc('id')
                    ->first()
                    ->id
            )
        ]);

        return [
            'hub_id' => $thread->id,
            'user_id' => User::factory()->create()->id,
            'message_id' => $this->getNextMessageId($this->model, $thread->id),
            'message' => $this->faker->text(),
        ];
    }

    /**
     * 書き込むスレッドを指定する
     * メッセージIDは自動更新する
     *
     * @param string $threadId スレッドID
     * @return ThreadFactory
     */
    public function thread(string $threadId): ThreadFactory
    {
        return $this->state(function (array $attributes) use ($threadId) {
            return [
                'hub_id' => $threadId,
                'message_id' => $this->getNextMessageId($this->model, $threadId),
            ];
        });
    }

    /**
     * 対応するスレッドにおける次のメッセージIDを取得する
     *
     * @param string $model モデルクラス名
     * @param string $threadId スレッドID
     * @return integer
     */
    private function getNextMessageId(string $model, string $threadId): int
    {
        return ThreadRepository::getMaxMessageId($model, $threadId) + 1;
    }
}
