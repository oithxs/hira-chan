<?php

namespace Database\Factories;

use App\Models\Hub;
use App\Models\LectureThread;
use App\Models\ThreadPrimaryCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LectureThread>
 */
class LectureThreadFactory extends Factory
{
    /**
     * factory の対象モデル．
     *
     * @link https://readouble.com/laravel/9.x/ja/database-testing.html
     *
     * @var string
     */
    protected $model = LectureThread::class;

    /**
     * モデルのデフォルトの状態を定義する．
     *
     * @link https://readouble.com/laravel/9.x/ja/database-testing.html
     *
     * @return array
     */
    public function definition()
    {
        $thread = Hub::factory()->create([
            'thread_secondary_category_id' => random_int(
                ThreadPrimaryCategory::where('name', '=', '授業')
                    ->first()
                    ->thread_secondary_categorys()
                    ->first()
                    ->id,
                ThreadPrimaryCategory::where('name', '=', '授業')
                    ->first()
                    ->thread_secondary_categorys()
                    ->orderByDesc('id')
                    ->first()
                    ->id
            )
        ]);

        return [
            'hub_id' => $thread->id,
            'user_id' => User::factory()->create()->id,
            'message_id' => LectureThread::where('hub_id', '=', $thread->id)
                ->max('message_id') + 1 ?? 0,
            'message' => $this->faker->text(),
        ];
    }
}
