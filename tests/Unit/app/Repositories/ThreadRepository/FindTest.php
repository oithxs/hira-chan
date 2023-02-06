<?php

namespace Tests\Unit\app\Repositories\ThreadRepository;

use App\Consts\Tables\ThreadsConst;
use App\Repositories\ThreadRepository;
use Error;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\AssertSame\AssertSameInterface;
use Tests\Support\AssertSame\Tables\ThreadsTrait;
use Tests\Support\PostTestTrait;
use Tests\TestCase;
use TypeError;

class FindTest extends TestCase implements AssertSameInterface
{
    use PostTestTrait,
        RefreshDatabase,
        ThreadsTrait;

    /**
     * @var array テスト対象のメソッド
     */
    private array $method;

    public function setUp(): void
    {
        parent::setUp();
        $this->postSetUp();

        // メンバ変数に値を代入する
        $this->method = [new ThreadRepository, 'find'];
    }

    /**
     * 期待する書き込みのデータを取得する
     *
     * @param array $args ['hubId', 'userId', 'messageId', 'message']の要素が必要
     * @return array
     */
    public function getValuesExpected(array $args): array
    {
        $expected = [];
        $expected[ThreadsConst::HUB_ID] = $args['hubId'] . '';
        $expected[ThreadsConst::USER_ID] = $args['userId'] . '';
        $expected[ThreadsConst::MESSAGE_ID] = $args['messageId'];
        $expected[ThreadsConst::MESSAGE] = $args['message'];
        return $expected;
    }

    /**
     * 書き込みが取得できることをアサートする
     *
     * @return void
     */
    public function testAssertThatThePostCanBeRetrieved(): void
    {
        for ($i = 0; $i < count(ThreadsConst::MODEL_FQCNS); $i++) {
            $response = ($this->method)(
                ThreadsConst::MODEL_FQCNS[$i],
                $this->posts[$i]->hub_id,
                $this->posts[$i]->message_id
            )->toArray();

            $this->post = $response;
            $this->assertSame($this->getKeysExpected(), array_keys($response));
            $this->assertSame($this->getValuesExpected([
                'hubId' => $this->posts[$i]->hub_id,
                'userId' => $this->posts[$i]->user_id,
                'messageId' => $this->posts[$i]->message_id,
                'message' => $this->posts[$i]->message
            ]), $this->getValuesActual());
        }
    }

    /**
     * 存在しないモデルを引数とする
     *
     * @return void
     */
    public function testArgumentIsAModelThatDoesNotExists(): void
    {
        $model = 'not existent model';
        for ($i = 0; $i < count($this->posts); $i++) {
            $this->assertThrows(
                fn () => ($this->method)(
                    $model,
                    $this->posts[$i]->hub_id,
                    $this->posts[$i]->message_id
                ),
                Error::class
            );
        }
    }

    /**
     * モデル未定義
     *
     * @return void
     */
    public function testModelUndefined(): void
    {
        for ($i = 0; $i < count($this->posts); $i++) {
            $this->assertThrows(
                fn () => ($this->method)(
                    threadId: $this->posts[$i]->hub_id,
                    messageId: $this->posts[$i]->message_id
                ),
                TypeError::class
            );
        }
    }

    /**
     * 存在しないスレッドIDを引数とする
     *
     * @return void
     */
    public function testArgumentIsAThreadIdThatDoesNotExists(): void
    {
        $threadId = 'not existent thread id';
        for ($i = 0; $i < count(ThreadsConst::MODEL_FQCNS); $i++) {
            $response = ($this->method)(
                ThreadsConst::MODEL_FQCNS[$i],
                $threadId,
                $this->posts[$i]->message_id
            );
            $this->assertSame(null, $response);
        }
    }

    /**
     * スレッドID未定義
     *
     * @return void
     */
    public function testThreadIdUndefined(): void
    {
        for ($i = 0; $i < count(ThreadsConst::MODEL_FQCNS); $i++) {
            $this->assertThrows(
                fn () => ($this->method)(
                    model: ThreadsConst::MODEL_FQCNS[$i],
                    messageId: $this->posts[$i]->message_id
                ),
                TypeError::class
            );
        }
    }

    /**
     * 存在しないメッセージIDを引数とする
     *
     * @return void
     */
    public function testArgumentIsAMessageIdThatDoesNotExists(): void
    {
        $messageId = -1;
        for ($i = 0; $i < count(ThreadsConst::MODEL_FQCNS); $i++) {
            $response = ($this->method)(
                ThreadsConst::MODEL_FQCNS[$i],
                $this->posts[$i]->hub_id,
                $messageId
            );
            $this->assertSame(null, $response);
        }
    }

    /**
     * メッセージID未定義
     *
     * @return void
     */
    public function testMessageIdUndefined(): void
    {
        for ($i = 0; $i < count(ThreadsConst::MODEL_FQCNS); $i++) {
            $this->assertThrows(
                fn () => ($this->method)(
                    model: ThreadsConst::MODEL_FQCNS[$i],
                    threadId: $this->posts[$i]->hub_id
                ),
                TypeError::class
            );
        }
    }
}
