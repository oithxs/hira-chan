<?php

namespace Tests\Unit\app\Services\PostService;

use App\Services\PostService;
use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\TestCase;
use TypeError;

class AddReplyTest extends TestCase
{
    private Generator $faker;

    /**
     * テスト対象のメソッド
     *
     * @var array
     */
    private array $method;

    public function setUp(): void
    {
        parent::setUp();

        // メンバ変数に値を代入する
        $this->faker = Factory::create();
        $this->method = [new PostService, 'addReply'];
    }

    /**
     * @see \App\Services\PostService::addReply
     * 上記のメソッドが変更されたときに備えてメソッドをコピーして使用（2023/01/28）
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
     * 加工したメッセージを取得できることをアサートする
     *
     * @return void
     */
    public function testAssertThatTheProcessedMessageCanBeObtained(): void
    {
        foreach (range(1, 999) as $num) {
            $message = $this->faker->text;
            $reply = (string) $num;
            $processedMessage = $this->addReply($message, $reply);

            $this->assertSame(
                $processedMessage,
                ($this->method)($message, $reply)
            );
        }
    }

    /**
     * メッセージ未定義
     *
     * @return void
     */
    public function testMessageUndefined(): void
    {
        $this->expectException(TypeError::class);
        $reply = (string) random_int(1, 999);
        ($this->method)($reply);
    }

    /**
     * 存在しないメッセージID（reply）を引数とする
     *
     * @return void
     */
    public function testArgumentIsMessageIdTHatDoesNotExists(): void
    {
        $message = $this->faker->text;
        $reply = (string) -1;
        $processedMessage = $this->addReply($message, $reply);

        $this->assertSame(
            $processedMessage,
            ($this->method)($message, $reply)
        );
    }

    /**
     * メッセージID（reply）未定義
     *
     * @return void
     */
    public function testReplyUndefined(): void
    {
        $message = $this->faker->text;
        $this->expectException(TypeError::class);
        ($this->method)($message);
    }
}
