<?php

namespace Tests\Unit\app\Repositories\ThreadRepository;

use App\Repositories\ThreadRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\PostTestTrait;
use Tests\TestCase;
use TypeError;

class GetHubIdTest extends TestCase
{
    use RefreshDatabase,
        PostTestTrait;

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
        $this->method = [new ThreadRepository, 'getHubId'];
    }

    /**
     * 書き込みの `hub_id` が取得できることをアサートする
     *
     * @return void
     */
    public function testAssertThatTheHubIdOfThePostCanBeObtained(): void
    {
        foreach ($this->posts as $post) {
            $hubId = ($this->method)($post);
            $this->assertTrue(is_string($hubId));
            $this->assertSame(
                $post->hub_id . '',
                $hubId
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
