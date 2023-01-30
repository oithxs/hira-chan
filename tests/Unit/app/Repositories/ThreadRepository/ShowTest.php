<?php

namespace Tests\Unit\app\Repositories\ThreadRepository;

use App\Consts\Tables\ThreadsConst;
use App\Models\Like;
use App\Models\ThreadImagePath;
use App\Models\ThreadModel;
use App\Models\User;
use App\Repositories\ThreadRepository;
use Error;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\AssertSame\AssertSameInterface;
use Tests\Support\AssertSame\Tables\ThreadsTrait;
use Tests\Support\ImageTestTrait;
use Tests\Support\PostTestTrait;
use Tests\TestCase;
use TypeError;

class ShowTest extends TestCase implements AssertSameInterface
{
    use PostTestTrait,
        RefreshDatabase,
        ImageTestTrait,
        ThreadsTrait;

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
        $this->method = [new ThreadRepository, 'show'];
    }

    /**
     * 書き込みを取得した際に期待する key を取得する
     *
     * @return array
     */
    private function getPostKeysExpected(): array
    {
        $expected = $this->getKeysExpected();
        $expected[] = 'likes_count';
        $expected[] = 'user';
        $expected[] = 'thread_image_path';
        $expected[] = 'likes';
        return $expected;
    }

    /**
     * 実際に取得した書き込みを返却する
     *
     * @return array
     */
    private function getPostValuesActual(): array
    {
        $postActualKeys = [
            'likes_count',
            'user',
            'thread_image_path',
            'likes',
        ];

        $actual = $this->getValuesActual();
        foreach ($postActualKeys as $postActualKey) {
            $actual[$postActualKey] = $this->post[$postActualKey];
        }
        return $actual;
    }

    /**
     * スレッドへの書き込みを保存するテーブルの
     * 期待するデータを取得する
     *
     * @param array $args
     * @return array
     */
    public function getValuesExpected(array $args): array
    {
        $post = $this->getExpectedPost(
            ThreadsConst::MODEL_FQCNS[$args['i']],
            $args['threadId'],
            $args['messageId']
        );

        $expected = [];
        $expected['hub_id'] = $post->hub_id;
        $expected['user_id'] = $post->user_id;
        $expected['message_id'] = $post->message_id;
        $expected['message'] = $post->message;
        $expected['likes_count'] = $this->getExpectedLikesCount(
            $args['i'],
            $args['postId'],
        );
        $expected['user'] = $this->getExpectedUser($args['userId']);
        $expected['thread_image_path'] = $this->getExpectedThreadImagePath(
            $args['i'],
            $args['postId']
        );
        $expected['likes'] = $this->getExpectedLike(
            $args['i'],
            $args['postId'],
            $args['login'] ?? ''
        );
        return $expected;
    }

    /**
     * 期待する書き込みをデータベースから取得する
     *
     * @param string $model
     * @param string $threadId
     * @param string $messageId
     * @return ThreadModel
     */
    private function getExpectedPost(string $model, string $threadId, string $messageId): ThreadModel
    {
        return $model::where([
            ['hub_id', $threadId],
            ['message_id', $messageId],
        ])->first();
    }

    /**
     * 対応する likes テーブルのデータを取得する
     *
     * @param integer $i
     * @param integer $postId
     * @return Builder
     */
    private function getLikeBuilder(int $i, int $postId): Builder
    {
        return Like::where([
            [ThreadsConst::USED_FOREIGN_KEYS[$i], $postId]
        ]);
    }

    /**
     * 期待する書き込みへのいいね数を取得する
     *
     * @param integer $i
     * @param integer $postId
     * @return integer
     */
    private function getExpectedLikesCount(int $i, int $postId): int
    {
        return $this->getLikeBuilder($i, $postId)->count();
    }

    /**
     * 期待するデータベースに保存されたいいねを取得する
     *
     * @param integer $i
     * @param integer $postId
     * @param string $userId
     * @return array
     */
    private function getExpectedLike(int $i, int $postId, string $userId): array
    {
        return $this->getLikeBuilder($i, $postId)
            ->where([[
                'user_id', $userId
            ]])->get()->toArray();
    }

    /**
     * 期待するデータベースに保存されたユーザを取得する
     *
     * @param string $userId
     * @return array
     */
    private function getExpectedUser(string $userId): array
    {
        return User::find($userId)->toArray();
    }

    /**
     * 期待するデータベースに保存された画像の情報を取得する
     *
     * @param integer $i
     * @param integer $postId
     * @return array|null
     */
    public function getExpectedThreadImagePath(int $i, int $postId): array | null
    {
        $response = ThreadImagePath::where([
            [ThreadsConst::USED_FOREIGN_KEYS[$i], $postId],
        ])->get()->toArray();

        return $response !== []
            ? $response[count($response) - 1]
            : null;
    }

    /**
     * 画像の情報をデータベースに保存する
     *
     * @param string $foreignKey
     * @param integer $postId
     * @param string $userId
     * @param string|null $imagePath
     * @param string|null $imageSize
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
     * @param array $posts
     * @param User|null $user
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
                ThreadsConst::MODEL_FQCNS[$i],
                $this->posts[$i][0]->hub_id,
                $this->user->id,
                0
            );

            for ($j = 0; $j < count($response); $j++) {
                $this->post = $response[$j]->toArray();
                $this->assertSame(
                    $this->getPostKeysExpected(),
                    array_keys($this->post)
                );
                $this->assertSame(
                    $this->getValuesExpected([
                        'i' => $i,
                        'postId' => $this->posts[$i][$j]->id,
                        'threadId' => $this->posts[$i][$j]->hub_id,
                        'messageId' => $this->posts[$i][$j]->message_id,
                        'userId' => $this->posts[$i][$j]->user_id
                    ]),
                    $this->getPostValuesActual()
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
                ThreadsConst::MODEL_FQCNS[$i],
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
                    $this->getPostKeysExpected(),
                    array_keys($this->post)
                );
                $this->assertSame(
                    $this->getValuesExpected([
                        'i' => $i,
                        'postId' => $this->posts[$i][$j + $preMaxMessageId]->id,
                        'threadId' => $this->posts[$i][$j + $preMaxMessageId]->hub_id,
                        'messageId' => $this->posts[$i][$j + $preMaxMessageId]->message_id,
                        'userId' => $this->posts[$i][$j + $preMaxMessageId]->user_id
                    ]),
                    $this->getPostValuesActual()
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
                ThreadsConst::MODEL_FQCNS[$i],
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
                ThreadsConst::MODEL_FQCNS[$i],
                $this->posts[$i][0]->hub_id,
                $this->user->id,
                0
            );

            for ($j = 0; $j < count($response); $j++) {
                $this->post = $response[$j]->toArray();
                $this->assertSame(
                    $this->getPostKeysExpected(),
                    array_keys($this->post)
                );
                $this->assertSame(
                    $this->getValuesExpected([
                        'i' => $i,
                        'postId' => $this->posts[$i][$j]->id,
                        'threadId' => $this->posts[$i][$j]->hub_id,
                        'messageId' => $this->posts[$i][$j]->message_id,
                        'userId' => $this->posts[$i][$j]->user_id
                    ]),
                    $this->getPostValuesActual()
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
                ThreadsConst::MODEL_FQCNS[$i],
                $this->posts[$i][0]->hub_id,
                $this->user->id,
                0
            );

            for ($j = 0; $j < count($response); $j++) {
                $this->post = $response[$j]->toArray();
                $this->assertSame(
                    $this->getPostKeysExpected(),
                    array_keys($this->post)
                );
                $this->assertSame(
                    $this->getValuesExpected([
                        'i' => $i,
                        'postId' => $this->posts[$i][$j]->id,
                        'threadId' => $this->posts[$i][$j]->hub_id,
                        'messageId' => $this->posts[$i][$j]->message_id,
                        'userId' => $this->posts[$i][$j]->user_id
                    ]),
                    $this->getPostValuesActual()
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
                ThreadsConst::MODEL_FQCNS[$i],
                $this->posts[$i][0]->hub_id,
                $this->user->id,
                0
            );

            for ($j = 0; $j < count($response); $j++) {
                $this->post = $response[$j]->toArray();
                $this->assertSame(
                    $this->getPostKeysExpected(),
                    array_keys($this->post)
                );
                $this->assertSame(
                    $this->getValuesExpected([
                        'i' => $i,
                        'postId' => $this->posts[$i][$j]->id,
                        'threadId' => $this->posts[$i][$j]->hub_id,
                        'messageId' => $this->posts[$i][$j]->message_id,
                        'userId' => $this->posts[$i][$j]->user_id,
                        'login' => $this->user->id,
                    ]),
                    $this->getPostValuesActual()
                );
            }
        }
    }

    /**
     * 存在しないモデルを引数とする
     *
     * @return void
     */
    public function testArgumentIsAModelThatDoesNotExist(): void
    {
        $model = 'not existent model';
        for ($i = 0; $i < count(ThreadsConst::MODEL_FQCNS); $i++) {
            $this->assertThrows(
                fn () => ($this->method)(
                    $model,
                    $this->posts[$i][0]->hub_id,
                    $this->user->id,
                    0
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
        for ($i = 0; $i < count(ThreadsConst::MODEL_FQCNS); $i++) {
            $this->assertThrows(
                fn () => ($this->method)(
                    $this->posts[$i][0]->hub_id,
                    $this->user->id,
                    0
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
                $this->user->id,
                0
            );

            $this->assertSame([], $response->toArray());
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
                    ThreadsConst::MODEL_FQCNS[$i],
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
                ThreadsConst::MODEL_FQCNS[$i],
                $this->posts[$i][0]->hub_id,
                $userId,
                0
            );

            for ($j = 0; $j < count($response); $j++) {
                $this->post = $response[$j]->toArray();
                $this->assertSame(
                    $this->getPostKeysExpected(),
                    array_keys($this->post)
                );
                $this->assertSame(
                    $this->getValuesExpected([
                        'i' => $i,
                        'postId' => $this->posts[$i][$j]->id,
                        'threadId' => $this->posts[$i][$j]->hub_id,
                        'messageId' => $this->posts[$i][$j]->message_id,
                        'userId' => $this->posts[$i][$j]->user_id,
                        'login' => $userId,
                    ]),
                    $this->getPostValuesActual()
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
                    ThreadsConst::MODEL_FQCNS[$i],
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
                ThreadsConst::MODEL_FQCNS[$i],
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
                    $this->getPostKeysExpected(),
                    array_keys($this->post)
                );
                $this->assertSame(
                    $this->getValuesExpected([
                        'i' => $i,
                        'postId' => $this->posts[$i][$j]->id,
                        'threadId' => $this->posts[$i][$j]->hub_id,
                        'messageId' => $this->posts[$i][$j]->message_id,
                        'userId' => $this->posts[$i][$j]->user_id
                    ]),
                    $this->getPostValuesActual()
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
                ThreadsConst::MODEL_FQCNS[$i],
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
                    ThreadsConst::MODEL_FQCNS[$i],
                    $this->posts[$i][0]->hub_id,
                    $this->user->id
                ),
                TypeError::class
            );
        }
    }
}
