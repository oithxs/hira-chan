<?php

namespace Database\Factories;

use App\Models\Hub;
use App\Models\ThreadSecondaryCategory;
use App\Models\User;
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
}
