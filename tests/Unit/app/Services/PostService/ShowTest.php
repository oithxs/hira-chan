<?php

namespace Tests\Unit\app\Services\PostService;

use App\Consts\Tables\ThreadsConst;
use App\Models\Like;
use App\Models\ThreadImagePath;
use App\Models\User;
use App\Services\PostService;
use ErrorException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\AssertSame\AssertSameInterface;
use Tests\Support\AssertSame\ExtPostTrait;
use Tests\Support\ImageTestTrait;
use Tests\Support\PostTestTrait;
use Tests\TestCase;
use TypeError;

class ShowTest extends TestCase implements AssertSameInterface
{
    use ExtPostTrait,
        PostTestTrait,
        RefreshDatabase,
        ImageTestTrait;

    private User $user;

    /**
     * テスト対象のメソッド
     *
     * @var array
     */
    private array $method;

    public function setUp(): void
    {
        parent::setUp();
        $this->multiPostsSetUp(10);

        // メンバ変数に値を代入する
        $this->user = User::factory()->create();
        $this->method = [new PostService, 'show'];
    }

    /**
     * 画像の情報をデータベースに保存する
     *
     * @param string $foreignKey 書き込んだスレッドの外部キー名
     * @param integer $postId 書き込みの主キー
     * @param string $userId 画像を保存するユーザID
     * @param string|null $imagePath 画像のパス
     * @param string|null $imageSize 画像のサイズ
     * @return void
     */
    private function storeThreadImagePath(
        string $foreignKey,
        int $postId,
        string $userId,
        string $imagePath = null,
        string $imageSize = null
    ): void {
        ThreadImagePath::create([
            $foreignKey => $postId,
            'user_id' => $userId,
            'img_path' => $imagePath ?? $this->makeImagePath(),
            'img_size' => $imageSize ?? $this->makeImageSize()
        ]);
    }

    /**
     * ダミーの画像データを保存する
     *
     * @return void
     */
    private function storeDummyImageData(): void
    {
        for ($i = 0; $i < count(ThreadsConst::MODEL_FQCNS); $i++) {
            $messageId = random_int(1, count($this->posts[$i]));
            $this->storeThreadImagePath(
                ThreadsConst::USED_FOREIGN_KEYS[$i],
                $this->posts[$i][$messageId - 1]->id,
                $this->posts[$i][$messageId - 1]->user_id
            );
        }
    }

    /**
     * いいねをデータベースに保存する
     *
     * @param array $posts いいねをつける書き込み
     * @param User|null $user いいねをつけるユーザ
     * @return void
     */
    private function storeLike(array $posts, User $user = null): void
    {
        foreach ($posts as $post) {
            $like_num = random_int(1, 10);
            foreach (range(1, $like_num) as $_) {
                Like::factory()->post($post)->create();
            }
            !$user ?: Like::factory()->post($post)->create([
                'user_id' => $user->id
            ]);
        }
    }

    /**
     * 書き込みが取得できることをアサートする
     *
     * @return void
     */
    public function testAssertsThatAPostCanBeObtained(): void
    {
        for ($i = 0; $i < count(ThreadsConst::MODEL_FQCNS); $i++) {
            $response = ($this->method)(
                $this->posts[$i][0]->hub_id,
                $this->user->id,
                0
            );

            for ($j = 0; $j < count($response); $j++) {
                $this->post = $response[$j]->toArray();
                $this->assertSame(
                    $this->getKeysExpected(),
                    array_keys($this->post)
                );
                $this->assertSame(
                    $this->getValuesExpected([
                        'model' => ThreadsConst::MODEL_FQCNS[$i],
                        'threadId' => $this->posts[$i][$j]->hub_id,
                        'messageId' => $this->posts[$i][$j]->message_id,
                    ]),
                    $this->getValuesActual()
                );
            }
        }
    }


    /**
     * 指定されたメッセージID以上の書き込みが取得できることをアサートする
     *
     * @return void
     */
    public function testAssertsThatItIsPossibleToGetMoreThanTheSpecifiedMessageIdPosts(): void
    {
        for ($i = 0; $i < count(ThreadsConst::MODEL_FQCNS); $i++) {
            $preMaxMessageId = random_int(1, count($this->posts[$i]) - 1);
            $post_num = count($this->posts[$i]) - $preMaxMessageId;
            $response = ($this->method)(
                $this->posts[$i][0]->hub_id,
                $this->user->id,
                $preMaxMessageId
            );

            // 取得した書き込み数は期待するものか
            $this->assertSame($post_num, count($response));

            $messageId = 0;
            for ($j = 0; $j < count($response); $j++) {
                $this->post = $response[$j]->toArray();

                // メッセージIDが昇順か
                $messageId < $this->post['message_id']
                    ? $this->assertTrue(true)
                    : $this->assertTrue(false);

                $messageId = $this->post['message_id'];

                // 前回取得したメッセージIDより今回の方が大きいか
                $messageId > $preMaxMessageId
                    ? $this->assertTrue(true)
                    : $this->assertTrue(false);

                // 取得した書き込みが期待するものか
                $this->assertSame(
                    $this->getKeysExpected(),
                    array_keys($this->post)
                );
                $this->assertSame(
                    $this->getValuesExpected([
                        'model' => ThreadsConst::MODEL_FQCNS[$i],
                        'threadId' => $this->posts[$i][$j + $preMaxMessageId]->hub_id,
                        'messageId' => $this->posts[$i][$j + $preMaxMessageId]->message_id,
                    ]),
                    $this->getValuesActual()
                );
            }
        }
    }

    /**
     * 最大メッセージIDを指定する
     *
     * @return void
     */
    public function testSpecifyMaximumMessageId(): void
    {
        for ($i = 0; $i < count(ThreadsConst::MODEL_FQCNS); $i++) {
            $preMaxMessageId = count($this->posts[$i]);
            $post_num = count($this->posts[$i]) - $preMaxMessageId;
            $response = ($this->method)(
                $this->posts[$i][0]->hub_id,
                $this->user->id,
                $preMaxMessageId
            );

            $this->assertSame($post_num, count($response));
            $this->assertSame([], $response->toArray());
        }
    }

    /**
     * 画像がアップロードされた書き込みを取得する
     *
     * @return void
     */
    public function testGetThePostsWhereTheImageWasUploaded(): void
    {
        $this->storeDummyImageData();

        for ($i = 0; $i < count(ThreadsConst::MODEL_FQCNS); $i++) {
            $response = ($this->method)(
                $this->posts[$i][0]->hub_id,
                $this->user->id,
                0
            );

            for ($j = 0; $j < count($response); $j++) {
                $this->post = $response[$j]->toArray();
                $this->assertSame(
                    $this->getKeysExpected(),
                    array_keys($this->post)
                );
                $this->assertSame(
                    $this->getValuesExpected([
                        'model' => ThreadsConst::MODEL_FQCNS[$i],
                        'threadId' => $this->posts[$i][$j]->hub_id,
                        'messageId' => $this->posts[$i][$j]->message_id,
                    ]),
                    $this->getValuesActual()
                );
            }
        }
    }

    /**
     * いいねがつけられた書き込みを取得する
     *
     * @return void
     */
    public function testRetrievePostsThatHaveBeenLiked(): void
    {
        for ($i = 0; $i < count(ThreadsConst::MODEL_FQCNS); $i++) {
            $this->storeLike($this->posts[$i]);
            $response = ($this->method)(
                $this->posts[$i][0]->hub_id,
                $this->user->id,
                0
            );

            for ($j = 0; $j < count($response); $j++) {
                $this->post = $response[$j]->toArray();
                $this->assertSame(
                    $this->getKeysExpected(),
                    array_keys($this->post)
                );
                $this->assertSame(
                    $this->getValuesExpected([
                        'model' => ThreadsConst::MODEL_FQCNS[$i],
                        'threadId' => $this->posts[$i][$j]->hub_id,
                        'messageId' => $this->posts[$i][$j]->message_id,
                    ]),
                    $this->getValuesActual()
                );
            }
        }
    }

    /**
     * 引数のユーザにいいねがつけられた書き込みを取得する
     *
     * @return void
     */
    public function testGetsThePostsLikedByTheArgumentUser(): void
    {
        for ($i = 0; $i < count(ThreadsConst::MODEL_FQCNS); $i++) {
            $this->storeLike($this->posts[$i], $this->user);
            $response = ($this->method)(
                $this->posts[$i][0]->hub_id,
                $this->user->id,
                0
            );

            for ($j = 0; $j < count($response); $j++) {
                $this->post = $response[$j]->toArray();
                $this->assertSame(
                    $this->getKeysExpected(),
                    array_keys($this->post)
                );
                $this->assertSame(
                    $this->getValuesExpected([
                        'model' => ThreadsConst::MODEL_FQCNS[$i],
                        'threadId' => $this->posts[$i][$j]->hub_id,
                        'messageId' => $this->posts[$i][$j]->message_id,
                        'loginUserId' => $this->user->id,
                    ]),
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
    public function testArgumentIsAThreadIdThatDoesNotExists(): void
    {
        $threadId = 'not existent thread id';
        for ($i = 0; $i < count(ThreadsConst::MODEL_FQCNS); $i++) {
            $this->assertThrows(
                fn () => ($this->method)(
                    $threadId,
                    $this->user->id,
                    0
                ),
                ErrorException::class
            );
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
                    $this->user->id,
                    0
                ),
                TypeError::class
            );
        }
    }

    /**
     * 存在しないユーザIDを引数とする
     *
     * @return void
     */
    public function testArgumentIsAUserIdThatDoesNotExists(): void
    {
        $userId = 'not existent user id';
        for ($i = 0; $i < count(ThreadsConst::MODEL_FQCNS); $i++) {
            $this->storeLike($this->posts[$i], $this->user);
            $response = ($this->method)(
                $this->posts[$i][0]->hub_id,
                $userId,
                0
            );

            for ($j = 0; $j < count($response); $j++) {
                $this->post = $response[$j]->toArray();
                $this->assertSame(
                    $this->getKeysExpected(),
                    array_keys($this->post)
                );
                $this->assertSame(
                    $this->getValuesExpected([
                        'model' => ThreadsConst::MODEL_FQCNS[$i],
                        'threadId' => $this->posts[$i][$j]->hub_id,
                        'messageId' => $this->posts[$i][$j]->message_id,
                        'loginUserId' => $userId,
                    ]),
                    $this->getValuesActual()
                );
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
        for ($i = 0; $i < count(ThreadsConst::MODEL_FQCNS); $i++) {
            $this->assertThrows(
                fn () => ($this->method)(
                    $this->posts[$i][0]->hub_id,
                    0
                ),
                TypeError::class
            );
        }
    }

    /**
     * 存在しないメッセージIDを引数とする
     * 最小メッセージIDよりも小さいもの
     *
     * @return void
     */
    public function testArgumentIsAPreMaxMessageIdThatDoesNotExistsLessThanMinimumMessageId(): void
    {
        $preMaxMessageId = -1;
        for ($i = 0; $i < count(ThreadsConst::MODEL_FQCNS); $i++) {
            $post_num = count($this->posts[$i]);
            $response = ($this->method)(
                $this->posts[$i][0]->hub_id,
                $this->user->id,
                $preMaxMessageId
            );

            // 取得した書き込み数は期待するものか
            $this->assertSame($post_num, count($response));

            $messageId = 0;
            for ($j = 0; $j < count($response); $j++) {
                $this->post = $response[$j]->toArray();

                // メッセージIDが昇順か
                $messageId < $this->post['message_id']
                    ? $this->assertTrue(true)
                    : $this->assertTrue(false);

                $messageId = $this->post['message_id'];

                // 前回取得したメッセージIDより今回の方が大きいか
                $messageId > $preMaxMessageId
                    ? $this->assertTrue(true)
                    : $this->assertTrue(false);

                // 取得した書き込みが期待するものか
                $this->assertSame(
                    $this->getKeysExpected(),
                    array_keys($this->post)
                );
                $this->assertSame(
                    $this->getValuesExpected([
                        'model' => ThreadsConst::MODEL_FQCNS[$i],
                        'threadId' => $this->posts[$i][$j]->hub_id,
                        'messageId' => $this->posts[$i][$j]->message_id,
                    ]),
                    $this->getValuesActual()
                );
            }
        }
    }

    /**
     * 存在しないメッセージIDを引数とする
     * 最大メッセージIDより大きい
     *
     * @return void
     */
    public function testArgumentIsAPreMaxMessageIdThatDoesNotExistsGreaterThanMaximumMessageId(): void
    {
        for ($i = 0; $i < count(ThreadsConst::MODEL_FQCNS); $i++) {
            $preMaxMessageId = count($this->posts[$i]) + 1;
            $post_num = 0;
            $response = ($this->method)(
                $this->posts[$i][0]->hub_id,
                $this->user->id,
                $preMaxMessageId
            );

            $this->assertSame($post_num, count($response));
            $this->assertSame([], $response->toArray());
        }
    }

    /**
     * 前回取得したメッセージID未定義
     *
     * @return void
     */
    public function testPreMaxMessageIdUndefined(): void
    {
        for ($i = 0; $i < count(ThreadsConst::MODEL_FQCNS); $i++) {
            $this->assertThrows(
                fn () => ($this->method)(
                    $this->posts[$i][0]->hub_id,
                    $this->user->id
                ),
                TypeError::class
            );
        }
    }
}
