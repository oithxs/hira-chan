<?php

namespace Tests\Unit\app\Repositories\ThreadRepository;

use App\Consts\Tables\ThreadsConst;
use App\Repositories\ThreadRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use TypeError;

class GetIdTest extends TestCase
{
    use RefreshDatabase;

    /**
     * スレッドへの書き込み
     *
     * @var array
     */
    private array $posts;

    public function setUp(): void
    {
        parent::setUp();

        // メンバ変数に値を代入する
        foreach (ThreadsConst::MODEL_FQCNS as $modelFQCN) {
            foreach (range(0, random_int(1, 100)) as $_) { // 1~100 の範囲に特に意味はなし
                $modelFQCN::factory()->create();
            }

            $this->posts[] = $modelFQCN::factory()->create();
        }
    }

    /**
     * 書き込みのIDが取得できることをアサートする
     *
     * @return void
     */
    public function testAssertThatTheIdOfTheWriteCanBeObtained(): void
    {
        foreach ($this->posts as $post) {
            $this->assertTrue(is_string(ThreadRepository::getId($post)));
            $this->assertEquals( // 型が異なるため，assertEquals を使用する．型が異なるのは問題なし
                $post->id,
                ThreadRepository::getId($post)
            );
        }
    }

    /**
     * 存在しない書き込みを引数とする
     *
     * @return void
     */
    public function testArgumentsForNotExistentPost(): void
    {
        $post = 'not existent post';
        $this->assertThrows(
            fn () => ThreadRepository::getId($post),
            TypeError::class
        );
    }

    /**
     * 書き込み未定義
     *
     * @return void
     */
    public function testPostUndefined(): void
    {
        $this->assertThrows(
            fn () => ThreadRepository::getId(),
            TypeError::class
        );
    }
}
