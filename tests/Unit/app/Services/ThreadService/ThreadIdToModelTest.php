<?php

namespace Tests\Unit\app\Services\ThreadService;

use App\Consts\Tables\ThreadsConst;
use App\Services\ThreadService;
use ErrorException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\ThreadTestTrait;
use Tests\TestCase;
use TypeError;

class ThreadIdToModelTest extends TestCase
{
    use ThreadTestTrait,
        RefreshDatabase;

    /**
     * @var array テスト対象のメソッド
     */
    private array $method;

    public function setUp(): void
    {
        parent::setUp();
        $this->threadSetUp();

        // メンバ変数に値を代入する
        $this->method = [new ThreadService, 'threadIdToModel'];
    }

    /**
     * スレッドIDから外部キー名を取得できることをアサートする
     *
     * @return void
     */
    public function testAssertThatTheForeignKeyNameCanBeObtainedFromTheThreadId(): void
    {
        foreach ($this->threads as $thread) {
            $response = ($this->method)($thread->id);
            $model = array_search(
                $thread->thread_secondary_category->thread_primary_category->name,
                ThreadsConst::MODEL_TO_CATEGORYS
            );
            $this->assertSame($model, $response);
        }
    }

    /**
     * 存在しないスレッドIDを引数とする
     *
     * @return void
     */
    public function testArgumentIsTheThreadIdThatDoesNotExists(): void
    {
        $threadId = 'not existent thread id';
        $this->assertThrows(
            fn () => ($this->method)($threadId),
            ErrorException::class
        );
    }

    /**
     * スレッドID未定義
     *
     * @return void
     */
    public function testThreadIdUndefined(): void
    {
        $this->assertThrows(
            fn () => ($this->method)(),
            TypeError::class
        );
    }
}
