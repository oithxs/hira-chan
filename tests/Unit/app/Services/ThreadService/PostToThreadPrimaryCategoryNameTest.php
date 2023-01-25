<?php

namespace Tests\Unit\app\Services\ThreadService;

use App\Consts\Tables\ThreadsConst;
use App\Services\ThreadService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\PostTestTrait;
use Tests\TestCase;
use TypeError;

class PostToThreadPrimaryCategoryNameTest extends TestCase
{
    use RefreshDatabase,
        PostTestTrait;

    private ThreadService $threadService;

    public function setUp(): void
    {
        parent::setUp();
        $this->postSetUp();

        // メンバ変数に値を代入する
        $this->threadService = new ThreadService();
    }

    /**
     * 取得した大枠カテゴリ名をアサートする
     *
     * @return void
     */
    public function testAssertTheObtainedThreadPrimaryCategoryName(): void
    {
        for ($i = 0; $i < count(ThreadsConst::TABLES); $i++) {
            $this->assertSame(
                ThreadsConst::CATEGORYS[$i],
                $this->threadService->postToThreadPrimaryCategoryName($this->posts[$i])
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
            fn () => $this->threadService->postToThreadPrimaryCategoryName($post),
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
            fn () => $this->threadService->postToThreadPrimaryCategoryName(),
            TypeError::class
        );
    }
}
