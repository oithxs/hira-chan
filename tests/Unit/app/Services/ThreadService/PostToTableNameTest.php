<?php

namespace Tests\Unit\app\Services\ThreadService;

use App\Consts\Tables\ThreadsConst;
use App\Services\ThreadService;
use Tests\Support\TestPost;
use Tests\TestCase;
use TypeError;

class PostToTableNameTest extends TestCase
{
    use TestPost;

    private ThreadService $threadService;

    public function setUp(): void
    {
        parent::setUp();
        $this->postSetUp();

        // メンバ変数に値を代入する
        $this->threadService = new ThreadService();
    }

    /**
     * 取得したテーブル名をアサートする
     *
     * @return void
     */
    public function testAssertTheObtainedTableName(): void
    {
        for ($i = 0; $i < count(ThreadsConst::TABLES); $i++) {
            $this->assertSame(
                ThreadsConst::TABLES[$i],
                $this->threadService->postToTableName($this->posts[$i])
            );
        }
    }

    /**
     * 存在しない書き込み（string）を引数とする
     *
     * @return void
     */
    public function testArgumentIsThePostThatDoesNotExists(): void
    {
        $post = 'not existent post';
        $this->assertThrows(
            fn () => $this->threadService->postToTableName($post),
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
            fn () => $this->threadService->postToTableName(),
            TypeError::class
        );
    }
}
