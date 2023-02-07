<?php

namespace Tests\Support;

use App\Consts\Tables\ThreadsConst;
use App\Models\Like;
use App\Models\ThreadModel;

trait LikeTestTrait
{
    /**
     * @var array スレッドへの書き込み
     */
    public array $posts;

    /**
     * @var array 書き込みへのいいね
     */
    public array $likes;

    /**
     * すべての大枠カテゴリの書き込みをメンバ変数に代入し，
     * すべての書き込みにいいねをする
     *
     * @param integer $num 書き込みにつけるいいね数
     * @return void
     */
    public function likeSetUp(int $num = 10): void
    {
        $this->posts = [];
        for ($i = 0; $i < count(ThreadsConst::MODEL_FQCNS); $i++) {
            $this->posts[$i] = ThreadsConst::MODEL_FQCNS[$i]::factory()->create();
            for ($j = 0; $j < $num; $j++) {
                $this->likes[$i][$j] = Like::factory()->post($this->posts[$i])->create();
            }
        }
    }
}
