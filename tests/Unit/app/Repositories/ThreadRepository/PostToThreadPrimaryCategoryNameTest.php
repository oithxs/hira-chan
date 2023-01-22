<?php

namespace Tests\Unit\app\Repositories\ThreadRepository;

use App\Consts\Tables\ThreadsConst;
use App\Repositories\ThreadRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\TestPost;
use Tests\TestCase;
use TypeError;

class PostToThreadPrimaryCategoryNameTest extends TestCase
{
    use RefreshDatabase,
        TestPost;


    /**
     * テースト対象のメソッド
     *
     * @var array
     */
    private array $method;

    public function setUp(): void
    {
        parent::setUp();
        $this->postSetUp();

        // メンバ変数に値を代入する
        $this->method = [new ThreadRepository, 'postToThreadPrimaryCategoryName'];
    }

    /**
     * 書き込みしたスレッドの大枠カテゴリ名が取得できることをアサートする
     *
     * @return void
     */
    public function testAssertThatTheThreadPrimaryCategoryNameOfThePostCanBeObtained(): void
    {
        for ($i = 0; $i < count($this->posts); $i++) {
            $this->assertSame(
                ThreadsConst::CATEGORYS[$i],
                ($this->method)($this->posts[$i])
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
            fn () => ($this->method)($post),
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
            fn () => ($this->method)(),
            TypeError::class
        );
    }
}
