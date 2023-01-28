<?php

namespace Database\Factories;

use App\Consts\Tables\ThreadsConst;
use App\Models\Hub;
use App\Models\ThreadPrimaryCategory;
use App\Models\User;
use App\Repositories\ThreadPrimaryCategoryRepository;
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
            'message_id' => $this->model::where('hub_id', '=', $thread->id)
                ->max('message_id') + 1 ?? 0,
            'message' => $this->faker->text(),
        ];
    }
}
