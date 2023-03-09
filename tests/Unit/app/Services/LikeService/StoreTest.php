<?php

namespace Tests\Unit\app\Services\LikeService;

use App\Consts\Tables\LikeConst;
use App\Consts\Tables\ThreadsConst;
use App\Models\Like;
use App\Models\User;
use App\Services\LikeService;
use Error;
use ErrorException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use ReflectionClass;
use Tests\Support\AssertSame\AssertSameInterface;
use Tests\Support\AssertSame\Tables\LikeTrait;
use Tests\Support\PostTestTrait;
use Tests\TestCase;
use TypeError;

class StoreTest extends TestCase implements AssertSameInterface
{
    use LikeTrait,
        PostTestTrait,
        RefreshDatabase;

    private User $user;

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
        $this->postSetUp();

        // メンバ変数に値を代入する
        $this->likeService = new LikeService;
        $reflection = new ReflectionClass($this->likeService);
        $this->propertyForeignKey = $reflection->getProperty('foreignKey');
        $this->propertyForeignKey->setAccessible(true);
        $this->propertyPostId = $reflection->getProperty('postId');
        $this->propertyPostId->setAccessible(true);
        $this->user = User::factory()->create();
    }

    /**
     * likesテーブルの期待するデータを取得する
     *
     * @param array $args ['外部キー名' => 書き込みのID, 'userId'] が必要
     * @return array likesテーブルの期待するデータ
     */
    public function getValuesExpected(array $args): array
    {
        $expected = [];
        foreach (ThreadsConst::USED_FOREIGN_KEYS as $foreignKey) {
            $expected[$foreignKey] = $args[$foreignKey] ?? null;
        }
        $expected[LikeConst::USER_ID] = $args['userId'] . '';
        return $expected;
    }

    /**
     * 対応するいいねを取得する
     *
     * @param string|null $foreignKey 書き込みを保存しているテーブルの外部キー
     * @param integer $postId 書き込みのID
     * @param string $userId いいねをしたユーザのID
     * @return array 書き込みにつけたいいねのデータ
     */
    private function getLike(string | null $foreignKey, int $postId, string $userId): array
    {
        $where = [];
        is_null($foreignKey) ?: $where[] = [$foreignKey, $postId];
        $where[] = ['user_id', $userId];

        return Like::where($where)->first()->toArray();
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
     * 投稿にいいねができることをアサートする
     *
     * @return void
     */
    public function testAssertThatACanLikeThePost(): void
    {
        for ($i = 0; $i < count($this->posts); $i++) {
            $this->likeService->store(
                $this->posts[$i]->hub_id,
                $this->posts[$i]->message_id,
                $this->user->id
            );

            $this->like = $this->getLike(
                ThreadsConst::USED_FOREIGN_KEYS[$i],
                $this->posts[$i]->id,
                $this->user->id
            );
            $this->assertSame($this->getKeysExpected(), array_keys($this->like));
            $this->assertSame($this->getValuesExpected([
                ThreadsConst::USED_FOREIGN_KEYS[$i] => $this->posts[$i]->id,
                'userId' => $this->user->id
            ]), $this->getValuesActual());

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

    /**
     * 同じ書き込みに複数のいいねができることをアサートする
     *
     * @return void
     */
    public function testAssertThatACanHaveMultipleLikesOnTheSamePost(): void
    {
        $users = [];
        foreach (range(1, 10) as $_) {
            $users[] = User::factory()->create();
        }

        for ($i = 0; $i < count($this->posts); $i++) {
            foreach ($users as $user) {
                $this->likeService->store(
                    $this->posts[$i]->hub_id,
                    $this->posts[$i]->message_id,
                    $user->id
                );
            }

            foreach ($users as $user) {
                $this->like = $this->getLike(
                    ThreadsConst::USED_FOREIGN_KEYS[$i],
                    $this->posts[$i]->id,
                    $user->id
                );
                $this->assertSame($this->getKeysExpected(), array_keys($this->like));
                $this->assertSame($this->getValuesExpected([
                    ThreadsConst::USED_FOREIGN_KEYS[$i] => $this->posts[$i]->id,
                    'userId' => $user->id
                ]), $this->getValuesActual());
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
        for ($i = 0; $i < count($this->posts); $i++) {
            $this->assertThrows(
                fn () => $this->likeService->store(
                    $threadId,
                    $this->posts[$i]->message_id,
                    $this->user->id
                ),
                ErrorException::class
            );
        }
        $this->assertSame([], $this->getAllLike());
    }

    /**
     * スレッドID未定義
     *
     * @return void
     */
    public function testThreadIdUndefined(): void
    {
        for ($i = 0; $i < count($this->posts); $i++) {
            $this->assertThrows(
                fn () => $this->likeService->store(
                    messageId: $this->posts[$i]->message_id,
                    userId: $this->user->id
                ),
                Error::class
            );
        }
        $this->assertSame([], $this->getAllLike());
    }

    /**
     * 存在しないメッセージIDを引数とする
     *
     * @return void
     */
    public function testArgumentIsAMessageIdThatDoesNotExist(): void
    {
        $messageId = -1;
        for ($i = 0; $i < count($this->posts); $i++) {
            $this->assertThrows(
                fn () => $this->likeService->store(
                    $this->posts[$i]->hub_id,
                    $messageId,
                    $this->user->id
                ),
                TypeError::class
            );
        }
        $this->assertSame([], $this->getAllLike());
    }

    /**
     * メッセージID未定義
     *
     * @return void
     */
    public function testMessageIdUndefined(): void
    {
        for ($i = 0; $i < count($this->posts); $i++) {
            $this->assertThrows(
                fn () => $this->likeService->store(
                    threadId: $this->posts[$i]->hub_id,
                    userId: $this->user->id
                ),
                Error::class
            );
        }
        $this->assertSame([], $this->getAllLike());
    }

    /**
     * 存在しないユーザIDを引数とする
     *
     * @return void
     */
    public function testArgumentIsAUserIdThatDoesNotExist(): void
    {
        $userId = 'not existent user id';
        for ($i = 0; $i < count($this->posts); $i++) {
            $this->assertThrows(
                fn () => $this->likeService->store(
                    $this->posts[$i]->hub_id,
                    $this->posts[$i]->message_id,
                    $userId
                ),
                QueryException::class
            );
        }
        $this->assertSame([], $this->getAllLike());
    }

    /**
     * ユーザID未定義
     *
     * @return void
     */
    public function testUserIdUndefined(): void
    {
        for ($i = 0; $i < count($this->posts); $i++) {
            $this->assertThrows(
                fn () => $this->likeService->store(
                    threadId: $this->posts[$i]->hub_id,
                    messageId: $this->posts[$i]->message_id
                ),
                Error::class
            );
        }
        $this->assertSame([], $this->getAllLike());
    }
}
