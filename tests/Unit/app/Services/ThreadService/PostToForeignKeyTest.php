<?php

namespace Tests\Unit\app\Services\ThreadService;

use App\Consts\Tables\ThreadsConst;
use App\Services\ThreadService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\TestPost;
use Tests\TestCase;
use TypeError;

class PostToForeignKeyTest extends TestCase
{
    use RefreshDatabase,
        TestPost;

    private ThreadService $threadService;

    public function setUp(): void
    {
        parent::setUp();
        $this->postSetUp();

        // メンバ変数に値を代入する
        $this->threadService = new ThreadService();
    }

    /**
     * 取得した外部キーをアサートする
     *
     * @return void
     */
    public function testAssertTheObtainedForeignKeyName(): void
    {
        for ($i = 0; $i < count(ThreadsConst::USED_FOREIGN_KEYS); $i++) {
            $this->assertSame(
                ThreadsConst::USED_FOREIGN_KEYS[$i],
                $this->threadService->postToForeignKey($this->posts[$i])
            );
        }
    }

    /**
     * 存在しない書き込み（string）を引数とする
     *
     * @return void
     */
    public function testArgumentIsThePostThatDoesNotExist(): void
    {
        $post = 'not existent post';
        $this->assertThrows(
            fn () => $this->threadService->postToForeignKey($post),
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
        $this->assertTHrows(
            fn () => $this->threadService->postToForeignKey(),
            TypeError::class
        );
    }
}
