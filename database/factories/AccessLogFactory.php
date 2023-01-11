<?php

namespace Database\Factories;

use App\Models\AccessLog;
use App\Models\Hub;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AccessLog>
 */
class AccessLogFactory extends Factory
{
    /**
     * factory の対象モデル．
     *
     * @link https://readouble.com/laravel/9.x/ja/database-testing.html
     *
     * @var string
     */
    protected $model = AccessLog::class;

    /**
     * モデルのデフォルトの状態を定義する．
     *
     * @link https://readouble.com/laravel/9.x/ja/database-testing.html
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $thread = Hub::factory()->create();
        return [
            'hub_id' => $thread->id,
        ];
    }

    /**
     * user_id カラムにデータを挿入する
     *
     * @param User|null $user
     * @return AccessLogFactory
     */
    public function user(User $user = null): AccessLogFactory
    {
        return $this->state(function () use ($user) {
            return [
                'user_id' => $user->id ?? User::factory()->create()->id,
            ];
        });
    }
}
