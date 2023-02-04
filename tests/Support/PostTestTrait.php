<?php

namespace Tests\Support;

use App\Consts\Tables\ThreadPrimaryCategoryConst;
use App\Consts\Tables\ThreadsConst;
use App\Consts\Tables\ThreadSecondaryCategoryConst;
use App\Models\Hub;
use App\Models\ThreadSecondaryCategory;

trait PostTestTrait
{
    /**
     * スレッドへの書き込み
     *
     * @var array
     */
    public array $posts;

    /**
     * すべての大枠カテゴリの書き込みをメンバ変数に代入する
     *
     * @return void
     */
    public function postSetUp(): void
    {
        $this->posts = [];
        foreach (ThreadsConst::MODEL_FQCNS as $modelFQCN) {
            $this->posts[] = $modelFQCN::factory()->create();
        }
    }

    /**
     * すべての詳細カテゴリの書き込みをメンバ変数に代入する
     *
     * @return void
     */
    public function allSecondaryCategoryPostSetUp(): void
    {
        $this->posts = [];
        for ($i = 0; $i < count(ThreadsConst::MODEL_FQCNS); $i++) {
            foreach (ThreadSecondaryCategoryConst::PRIMARY_IN_SECONDARY_CATEGORYS[ThreadPrimaryCategoryConst::PRIMARY_CATEGORYS[$i]] as $secondary_category) {
                $thread = Hub::factory()->create([
                    'thread_secondary_category_id' => ThreadSecondaryCategory::where('name', $secondary_category)->first()->id
                ]);
                $this->posts[] = ThreadsConst::MODEL_FQCNS[$i]::factory()->create([
                    'hub_id' => $thread->id
                ]);
            }
        }
    }

    /**
     * 指定された数，すべての大枠カテゴリの書き込みをメンバ変数に代入する
     *
     * @param integer $max
     * @return void
     */
    public function multiPostsSetUp(int $max): void
    {
        $this->posts = [];
        for ($i = 0; $i < count(ThreadsConst::CATEGORYS); $i++) {
            $thread = Hub::factory()->primaryCategory(ThreadsConst::CATEGORYS[$i])->create();
            foreach (range(1, $max) as $_) {
                $this->posts[$i][] = ThreadsConst::MODEL_FQCNS[$i]::factory()->thread($thread->id)->create();
            }
        }
    }
}
