<?php

namespace Tests\Unit\app\Services\LikeService;

use App\Consts\Tables\ThreadsConst;
use App\Models\Like;
use App\Services\LikeService;
use Error;
use ErrorException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use ReflectionClass;
use Tests\Support\LikeTestTrait;
use Tests\TestCase;
use TypeError;

class DestroyTest extends TestCase
{
    use LikeTestTrait,
        RefreshDatabase;

    /**
     * @var mixed テスト対象メソッドがあるクラスのプライベートなメンバ変数 foreignKey
     */
    private mixed $propertyForeignKey;

    /**
     * @var mixed テスト対象メソッドがあるクラスのプライベートなメンバ変数 postId
     */
    private mixed $propertyPostId;

    private LikeService $likeService;

    public function setUp(): void
    {
        parent::setUp();
        $this->likeSetUp();
        
        // メンバ変数に値を代入する
        $this->likeService = new LikeService;
        $reflection = new ReflectionClass($this->likeService);
        $this->propertyForeignKey = $reflection->getProperty('foreignKey');
        $this->propertyForeignKey->setAccessible(true);
        $this->propertyPostId = $reflection->getProperty('postId');
        $this->propertyPostId->setAccessible(true);
    }

    /**
     * 対応するいいねを取得する
     *
     * @param string|null $foreignKey 書き込みを保存しているテーブルの外部キー
     * @param integer $postId 書き込みのID
     * @param string $userId いいねをしたユーザのID
     * @return array 書き込みにつけたいいねのデータ
     */
    private function getLike(
        string | null $foreignKey,
        int $postId,
        string $userId
    ): array {
        $where = [];
        is_null($foreignKey) ?: $where[] = [$foreignKey, $postId];
        $where[] = ['user_id', $userId];

        return Like::where($where)->get()->toArray();
    }

    /**
     * likesテーブルの全データを取得する
     *
     * @return array likesテーブルの全データ
     */
    private function getAllLike(): array
    {
        return Like::get()->toArray();
    }

    /**
     * 書き込みのいいねが削除されることをアサートする
     *
     * @return void
     */
    public function testAssertThatThePostLikesWillBeDeleted(): void
    {
        for ($i = 0; $i < count($this->likes); $i++) {
            for ($j = 0; $j < count($this->likes[$i]); $j++) {
                $this->likeService->destroy(
                    $this->posts[$i]->hub_id,
                    $this->posts[$i]->message_id,
                    $this->likes[$i][$j]->user_id
                );
                $this->assertSame(
                    [],
                    $this->getLike(
                        ThreadsConst::USED_FOREIGN_KEYS[$i],
                        $this->posts[$i]->id,
                        $this->likes[$i][$j]->user_id
                    )
                );
                // メンバ変数に期待する値が入っているかどうか
                $this->assertSame(
                    ThreadsConst::USED_FOREIGN_KEYS[$i],
                    $this->propertyForeignKey->getValue($this->likeService)
                );
                $this->assertSame(
                    $this->posts[$i]->id,
                    $this->propertyPostId->getValue($this->likeService)
                );
            }
        }
        $this->assertSame([], $this->getAllLike());
    }

    /**
     * 存在しないスレッドIDを引数とする
     *
     * @return void
     */
    public function testArgumentIsAThreadIdThatDoesNotExist(): void
    {
        $threadId = 'not existent foreign key';
        for ($i = 0; $i < count($this->likes); $i++) {
            for ($j = 0; $j < count($this->likes[$i]); $j++) {
                $this->assertThrows(
                    fn () => $this->likeService->destroy(
                        $threadId,
                        $this->posts[$i]->id,
                        $this->likes[$i][$j]->user_id
                    ),
                    ErrorException::class
                );
            }
        }
        [] !== $this->getAllLike()
            ? $this->assertTrue(true)
            : $this->assertTrue(false);
    }

    /**
     * スレッドID未定義
     *
     * @return void
     */
    public function testThreadIdUndefined(): void
    {
        for ($i = 0; $i < count($this->likes); $i++) {
            for ($j = 0; $j < count($this->likes[$i]); $j++) {
                $this->assertThrows(
                    fn () => $this->likeService->destroy(
                        messageId: $this->posts[$i]->id,
                        userId: $this->likes[$i][$j]->user_id
                    ),
                    Error::class
                );
            }
        }
        [] !== $this->getAllLike()
            ? $this->assertTrue(true)
            : $this->assertTrue(false);
    }

    /**
     * 存在しないメッセージIDを引数とする
     *
     * @return void
     */
    public function testArgumentIsAMessageIdThatDoesNotExist(): void
    {
        $messageId = -1;
        for ($i = 0; $i < count($this->likes); $i++) {
            for ($j = 0; $j < count($this->likes[$i]); $j++) {
                $this->assertThrows(
                    fn () => $this->likeService->destroy(
                        $this->posts[$i]->hub_id,
                        $messageId,
                        $this->likes[$i][$j]->user_id
                    ),
                    TypeError::class
                );
            }
        }
        [] !== $this->getAllLike()
            ? $this->assertTrue(true)
            : $this->assertTrue(false);
    }

    /**
     * メッセージID未定義
     *
     * @return void
     */
    public function testMessageIdUndefined(): void
    {
        for ($i = 0; $i < count($this->likes); $i++) {
            for ($j = 0; $j < count($this->likes[$i]); $j++) {
                $this->assertThrows(
                    fn () => $this->likeService->destroy(
                        threadId: $this->posts[$i]->hub_id,
                        userId: $this->likes[$i][$j]->user_id
                    ),
                    Error::class
                );
            }
        }
        [] !== $this->getAllLike()
            ? $this->assertTrue(true)
            : $this->assertTrue(false);
    }

    /**
     * 存在しないユーザIDを引数とする
     *
     * @return void
     */
    public function testArgumentIsAUserIdThatDoesNotExist(): void
    {
        $userId = 'not existent user id';
        for ($i = 0; $i < count($this->likes); $i++) {
            for ($j = 0; $j < count($this->likes[$i]); $j++) {
                $this->likeService->destroy(
                    $this->posts[$i]->hub_id,
                    $this->posts[$i]->message_id,
                    $userId
                );
            }
        }
        [] !== $this->getAllLike()
            ? $this->assertTrue(true)
            : $this->assertTrue(false);
    }

    /**
     * ユーザID未定義
     *
     * @return void
     */
    public function testUserIdUndefined(): void
    {
        for ($i = 0; $i < count($this->likes); $i++) {
            for ($j = 0; $j < count($this->likes[$i]); $j++) {
                $this->assertThrows(
                    fn () => $this->likeService->destroy(
                        threadId: $this->posts[$i]->hub_id,
                        messageId: $this->posts[$i]->message_id
                    ),
                    Error::class
                );
            }
        }
        [] !== $this->getAllLike()
            ? $this->assertTrue(true)
            : $this->assertTrue(false);
    }
}
