<?php

namespace Tests\Support;

use App\Consts\Tables\ThreadsConst;
use App\Models\Hub;
use App\Models\ThreadPrimaryCategory;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait ThreadTestTrait
{
    public array $threads;

    /**
     * すべての大枠カテゴリのスレッドをメンバ変数に代入する
     *
     * @return void
     */
    public function threadSetUp(): void
    {
        $this->threads = [];
        foreach (ThreadsConst::CATEGORYS as $primaryCategory) {
            $this->threads[] = Hub::factory()->create([
                'thread_secondary_category_id' => random_int(
                    $this->getThreadSecondaryCategory($primaryCategory)->first()->id,
                    $this->getThreadSecondaryCategory($primaryCategory)->orderByDesc('id')->first()->id
                )
            ]);
        }
    }

    /**
     * 引数の大枠カテゴリ名に属する詳細カテゴリを返却する
     *
     * @param string $primaryCategory 大枠カテゴリ名
     * @return HasMany
     */
    public function getThreadSecondaryCategory(string $primaryCategory): HasMany
    {
        return ThreadPrimaryCategory::where('name', $primaryCategory)
            ->first()
            ->thread_secondary_categorys();
    }
}
