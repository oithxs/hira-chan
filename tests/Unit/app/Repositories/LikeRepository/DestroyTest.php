<?php

namespace Tests\Unit\app\Repositories\LikeRepository;

use App\Consts\Tables\ThreadsConst;
use App\Models\Like;
use App\Repositories\LikeRepository;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\LikeTestTrait;
use Tests\TestCase;
use TypeError;

class DestroyTest extends TestCase
{
    use LikeTestTrait,
        RefreshDatabase;

    /**
     * @var array テスト対象のメソッド
     */
    private array $method;

    public function setUp(): void
    {
        parent::setUp();
        $this->likeSetUp();

        // メンバ変数に値を代入する
        $this->method = [new LikeRepository, 'destroy'];
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
                ($this->method)(
                    ThreadsConst::USED_FOREIGN_KEYS[$i],
                    $this->posts[$i]->id,
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
            }
        }
        $this->assertSame([], $this->getAllLike());
    }

    /**
     * 存在しない外部キー名を引数とする
     *
     * @return void
     */
    public function testArgumentIsAForeignKeyThatDoesNotExist(): void
    {
        $foreignKey = 'not existent foreign key';
        for ($i = 0; $i < count($this->likes); $i++) {
            for ($j = 0; $j < count($this->likes[$i]); $j++) {
                $this->assertThrows(
                    fn () => ($this->method)(
                        $foreignKey,
                        $this->posts[$i]->id,
                        $this->likes[$i][$j]->user_id
                    ),
                    QueryException::class
                );
            }
        }
        [] !== $this->getAllLike()
            ? $this->assertTrue(true)
            : $this->assertTrue(false);
    }

    /**
     * 外部キー名未定義
     *
     * @return void
     */
    public function testForeignKeyUndefined(): void
    {
        for ($i = 0; $i < count($this->likes); $i++) {
            for ($j = 0; $j < count($this->likes[$i]); $j++) {
                $this->assertThrows(
                    fn () => ($this->method)(
                        postId: $this->posts[$i]->id,
                        userId: $this->likes[$i][$j]->user_id
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
     * 存在しない書き込みIDを引数とする
     *
     * @return void
     */
    public function testArgumentIsAPostIdThatDoesNotExist(): void
    {
        $postId = -1;
        for ($i = 0; $i < count($this->likes); $i++) {
            for ($j = 0; $j < count($this->likes[$i]); $j++) {
                ($this->method)(
                    ThreadsConst::USED_FOREIGN_KEYS[$i],
                    $postId,
                    $this->likes[$i][$j]->user_id
                );
            }
        }
        [] !== $this->getAllLike()
            ? $this->assertTrue(true)
            : $this->assertTrue(false);
    }

    /**
     * 書き込みID未定義
     *
     * @return void
     */
    public function testPostIdUndefined(): void
    {
        for ($i = 0; $i < count($this->likes); $i++) {
            for ($j = 0; $j < count($this->likes[$i]); $j++) {
                $this->assertThrows(
                    fn () => ($this->method)(
                        foreignKey: ThreadsConst::USED_FOREIGN_KEYS[$i],
                        userId: $this->likes[$i][$j]->user_id
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
     * 存在しないユーザIDを引数とする
     *
     * @return void
     */
    public function testArgumentIsAUserIdThatDoesNotExist(): void
    {
        $userId = 'not existent user id';
        for ($i = 0; $i < count($this->likes); $i++) {
            for ($j = 0; $j < count($this->likes[$i]); $j++) {
                ($this->method)(
                    ThreadsConst::USED_FOREIGN_KEYS[$i],
                    $this->posts[$i]->id,
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
                    fn () => ($this->method)(
                        foreignKey: ThreadsConst::USED_FOREIGN_KEYS[$i],
                        postId: $this->posts[$i]->id,
                    ),
                    TypeError::class
                );
            }
        }
        [] !== $this->getAllLike()
            ? $this->assertTrue(true)
            : $this->assertTrue(false);
    }
}
