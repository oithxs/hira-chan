<?php

namespace Tests\Unit\app\Services\PostService;

use App\Consts\Tables\ThreadsConst;
use App\Models\User;
use App\Services\PostService;
use ErrorException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\AssertSame\AssertSameInterface;
use Tests\Support\AssertSame\Tables\ThreadsTrait;
use Tests\Support\ThreadTestTrait;
use Tests\TestCase;
use TypeError;

class StoreTest extends TestCase implements AssertSameInterface
{
    use ThreadsTrait,
        ThreadTestTrait,
        RefreshDatabase;

    /**
     * @see \App\Services\Support\HtmlSpecialCharsService::HTML_SPECIAL_CHARACTER
     * 上記の定数が変更されたときに備えて，定数をコピーして使用（2023/01/27）
     */
    const HTML_SPECIAL_CHARACTER = [
        '&' => '&amp;',
        '<' => '&lt;',
        '>' => '&gt;',
        ' ' => '&ensp;',
        '　' => '&emsp;',
        "\n" => '<br>',
        "\t" => '&ensp;&ensp;'
    ];

    private User $user;

    /**
     * テスト対象のメソッド
     *
     * @var array
     */
    private array $method;

    /**
     * メッセージID
     *
     * @var integer
     */
    private int $message_id;

    /**
     * 書き込み
     *
     * @var string
     */
    private string $message;

    public function setUp(): void
    {
        parent::setUp();
        $this->threadSetUp();

        // メンバ変数に値を代入する
        $this->user = User::factory()->create();
        $this->method = [new PostService, 'store'];
    }

    /**
     * 書き込みの期待するデータを返却する
     *
     * @param array $args
     * @return array
     */
    public function getValuesExpected(array $args): array
    {
        $expected = [];
        $expected['hub_id'] = $this->threads[$args['i']]->id . '';
        $expected['user_id'] = $this->user->id . '';
        $expected['message_id'] = $this->message_id++;

        if (isset($args['reply'])) {
            $message = $this->encode($this->message);
            $expected['message'] = $this->addReply($message, $args['reply']);
        } else {
            $expected['message'] = $this->encode($this->message);
        }

        return $expected;
    }

    /**
     * 対応する書き込みを取得する
     *
     * @param integer $i
     * @return array
     */
    private function getPost(int $i): array
    {
        return ThreadsConst::MODEL_FQCNS[$i]::where([
            ['hub_id', $this->threads[$i]->id],
            ['message_id', $this->message_id]
        ])->first()->toArray();
    }

    /**
     * すべての書き込みを取得する
     *
     * @param integer $i
     * @return array
     */
    private function getAllPost(int $i): array
    {
        return ThreadsConst::MODEL_FQCNS[$i]::where([
            ['hub_id', $this->threads[$i]->id]
        ])->get()->toArray();
    }

    /**
     * 対応するスレッドの最大メッセージIDを取得する
     *
     * @param integer $i
     * @return integer
     */
    private function getMaxMessageId(int $i): int
    {
        return ThreadsConst::MODEL_FQCNS[$i]::where([
            ['hub_id', $this->threads[$i]->id]
        ])->max('message_id');
    }

    /**
     * @see \App\Services\Support\HtmlSpecialCharsService::encode
     * 上記のメソッドが変更されたときに備えて，メソッドをコピーして使用（2023/01/27）
     *
     * @param string $text
     * @return string
     */
    private function encode(string $text): string
    {
        foreach (self::HTML_SPECIAL_CHARACTER as $key => $value) {
            $text = str_replace($key, $value, $text);
        }
        return $text;
    }

    /**
     * @see \App\Services\PostService::addReply
     * 上記のメソッドが変更されたときに備えてメソッドをコピーして使用（2023/01/27）
     *
     * @param string $text スレッドに書き込む内容
     * @param string $reply 書き込みの返信先`message_id`
     * @return string
     */
    private function addReply(string $text, string $reply): string
    {
        if ($reply !== null) {
            $reply = '<a class="bg-info" href="#thread_message_id_' . str_replace('>>> ', '', $reply) . '">' . $reply . '</a>';
            $text = $reply . '<br>' . $text;
        }
        return $text;
    }

    /**
     * スレッドへの書き込みがデータベースに保存できることをアサートする
     *
     * @return void
     */
    public function testAssertThatPostsToAThreadCanBeStoredInTheDatabase(): void
    {
        for ($i = 0; $i < count($this->threads); $i++) {
            $this->message_id = 1;

            foreach (range(1, 10) as $_) {
                $this->message = fake()->text;
                ($this->method)(
                    $this->threads[$i]->id,
                    $this->user->id,
                    $this->message,
                    null
                );

                $this->post = $this->getPost($i);
                $this->assertSame($this->getKeysExpected(), array_keys($this->post));
                $this->assertSame(
                    $this->getValuesExpected(['i' => $i]),
                    $this->getValuesActual()
                );
            }
        }
    }

    /**
     * 書き込みの返信がデータベースに保存できることをアサートする
     *
     * @return void
     */
    public function testAssertsThatRepliesToAPostCanBeStoredInTheDatabase(): void
    {
        for ($i = 0; $i < count($this->threads); $i++) {
            $this->message = fake()->text;
            ($this->method)(
                $this->threads[$i]->id,
                $this->user->id,
                $this->message,
                null
            );
        }

        for ($i = 0; $i < count($this->threads); $i++) {
            $this->message_id = 2;

            foreach (range(1, 10) as $_) {
                $this->message = fake()->text;
                $reply = random_int(1, $this->getMaxMessageId($i));

                ($this->method)(
                    $this->threads[$i]->id,
                    $this->user->id,
                    $this->message,
                    $reply
                );

                $this->post = $this->getPost($i);
                $this->assertSame($this->getKeysExpected(), array_keys($this->post));
                $this->assertSame(
                    $this->getValuesExpected(['i' => $i, 'reply' => $reply]),
                    $this->getValuesActual()
                );
            }
        }
    }

    /**
     * 存在しないスレッドIDを引数とする
     *
     * @return void
     */
    public function testArgumentIsAThreadIdThatDoesNotExist(): void
    {
        $threadId = 'not existent thread id';

        for ($i = 0; $i < count($this->threads); $i++) {
            $this->message_id = 1;

            foreach (range(1, 10) as $_) {
                $this->message = fake()->text;

                $this->assertThrows(
                    fn () => ($this->method)(
                        $threadId,
                        $this->user->id,
                        $this->message,
                        null
                    ),
                    ErrorException::class
                );
                $this->assertSame([], $this->getAllPost($i));
            }
        }
    }

    /**
     * スレッドID未定義
     *
     * @return void
     */
    public function testThreadIdUndefined(): void
    {
        for ($i = 0; $i < count($this->threads); $i++) {
            $this->message_id = 1;

            foreach (range(1, 10) as $_) {
                $this->message = fake()->text;

                $this->assertThrows(
                    fn () => ($this->method)(
                        $this->user->id,
                        $this->message,
                        null,
                    ),
                    TypeError::class
                );
                $this->assertSame([], $this->getAllPost($i));
            }
        }
    }

    /**
     * 存在しないユーザIDを引数とする
     *
     * @return void
     */
    public function testArgumentIsAUserIdThatDoesNotExist(): void
    {
        $userId = 'not existent user id';
        for ($i = 0; $i < count($this->threads); $i++) {
            $this->message_id = 1;

            foreach (range(1, 10) as $_) {
                $this->message = fake()->text;

                $this->assertThrows(
                    fn () => ($this->method)(
                        $this->threads[$i]->id,
                        $userId,
                        $this->message,
                        null
                    ),
                    QueryException::class
                );
                $this->assertSame([], $this->getAllPost($i));
            }
        }
    }

    /**
     * ユーザID未定義
     *
     * @return void
     */
    public function testUserIdUndefined(): void
    {
        for ($i = 0; $i < count($this->threads); $i++) {
            $this->message_id = 1;

            foreach (range(1, 10) as $_) {
                $this->message = fake()->text;

                $this->assertThrows(
                    fn () => ($this->method)(
                        $this->threads[$i]->id,
                        $this->message,
                        null
                    ),
                    TypeError::class
                );
                $this->assertSame([], $this->getAllPost($i));
            }
        }
    }

    /**
     * メッセージ未定義
     *
     * @return void
     */
    public function testMessageUndefined(): void
    {
        for ($i = 0; $i < count($this->threads); $i++) {
            $this->message_id = 1;

            foreach (range(1, 10) as $_) {
                $this->message = fake()->text;

                $this->assertThrows(
                    fn () => ($this->method)(
                        $this->threads[$i]->id,
                        $this->user->id,
                        null
                    ),
                    TypeError::class
                );
                $this->assertSame([], $this->getAllPost($i));
            }
        }
    }

    /**
     * 存在しない Reply (message_id)を引数とする
     *
     * @return void
     */
    public function testArgumentIsAReplyThatDoesNotExist(): void
    {
        for ($i = 0; $i < count($this->threads); $i++) {
            $this->message = fake()->text;
            ($this->method)(
                $this->threads[$i]->id,
                $this->user->id,
                $this->message,
                null
            );
        }

        for ($i = 0; $i < count($this->threads); $i++) {
            $this->message_id = 2;

            foreach (range(1, 10) as $_) {
                $this->message = fake()->text;
                $reply = -1;

                ($this->method)(
                    $this->threads[$i]->id,
                    $this->user->id,
                    $this->message,
                    $reply
                );

                $this->post = $this->getPost($i);
                $this->assertSame($this->getKeysExpected(), array_keys($this->post));
                $this->assertSame(
                    $this->getValuesExpected(['i' => $i, 'reply' => $reply]),
                    $this->getValuesActual()
                );
            }
        }
    }

    /**
     * reply 未定義
     *
     * @return void
     */
    public function testReplyUndefined(): void
    {
        for ($i = 0; $i < count($this->threads); $i++) {
            $this->message = fake()->text;

            $this->assertThrows(
                fn () => ($this->method)(
                    $this->threads[$i]->id,
                    $this->user->id,
                    $this->message
                ),
                TypeError::class
            );
        }
    }
}
