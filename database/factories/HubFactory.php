<?php

namespace Database\Factories;

use App\Models\Hub;
use App\Models\ThreadPrimaryCategory;
use App\Models\ThreadSecondaryCategory;
use App\Models\User;
use App\Repositories\ThreadPrimaryCategoryRepository;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hub>
 */
class HubFactory extends Factory
{
    /**
     * factory の対象モデル．
     *
     * @link https://readouble.com/laravel/9.x/ja/database-testing.html
     *
     * @var string
     */
    protected $model = Hub::class;

    /**
     * モデルのデフォルトの状態を定義する．
     *
     * @link https://readouble.com/laravel/9.x/ja/database-testing.html
     *
     * @return array
     */
    public function definition()
    {
        return [
            'thread_secondary_category_id' => random_int(
                1,
                ThreadSecondaryCategory::count()
            ),
            'user_id' => User::factory()->create()->id,
            'name' => $this->faker->name(),
        ];
    }

    /**
     * 大枠カテゴリを指定する
     *
     * @param string $primaryCategory
     * @return HubFactory
     */
    public function primaryCategory(string $primaryCategory): HubFactory
    {
        return $this->state(function (array $attributes) use ($primaryCategory) {
            return [
                'thread_secondary_category_id' => random_int(
                    ThreadPrimaryCategoryRepository::getThreadSecondaryCategoryHasMany($primaryCategory)
                        ->first()
                        ->id,
                    ThreadPrimaryCategoryRepository::getThreadSecondaryCategoryHasMany($primaryCategory)
                        ->orderByDesc('id')
                        ->first()
                        ->id
                ),
            ];
        });
    }
}
