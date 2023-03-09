<?php

namespace Tests\Unit\app\Services\LikeService;

use App\Consts\Tables\ThreadsConst;
use App\Models\Like;
use App\Models\ThreadModel;
use App\Models\User;
use App\Services\LikeService;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use ReflectionClass;
use Tests\Support\PostTestTrait;
use Tests\TestCase;
use TypeError;

class CountLikeTest extends TestCase
{
    use PostTestTrait,
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

    private User $user;

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
     * 書き込みに指定された範囲内のランダムな数，
     * いいねをする
     *
     * @param ThreadModel $post いいねをする書き込み
     * @param integer $max いいねをするランダムな範囲の最大数
     * @param integer $min いいねをするランダムな範囲の最小数
     * @return integer 指定された書き込みにいいねをした数
     */
    private function setLikes(ThreadModel $post, $max = 20, $min = 10): int
    {
        $num = random_int($min, $max);
        foreach (range(1, $num) as $_) {
            Like::factory()->post($post)->create();
        }
        return $num;
    }

    /**
     * 書き込みのいいね数を取得できることをアサートする
     *
     * @return void
     */
    public function testAssertThatCanGetTheNumberOfLikesForAPost(): void
    {
        for ($i = 0; $i < count(ThreadsConst::USED_FOREIGN_KEYS); $i++) {
            $likes_num = $this->setLikes($this->posts[$i]);

            $response = $this->likeService->countLike(
                ThreadsConst::USED_FOREIGN_KEYS[$i],
                $this->posts[$i]->id
            );
            $this->assertSame($likes_num, $response);
        }
    }

    /**
     * いいねをした書き込みに保存されているいいね数を，
     * 取得できることをアサートする
     *
     * @return void
     */
    public function testAssertThatCanGetTheNumberOfLikesDoneToAPostThatHaveLiked(): void
    {
        for ($i = 0; $i < count(ThreadsConst::USED_FOREIGN_KEYS); $i++) {
            $likes_num = $this->setLikes($this->posts[$i]);
            $this->propertyForeignKey
                ->setValue($this->likeService, ThreadsConst::USED_FOREIGN_KEYS[$i]);
            $this->propertyPostId
                ->setValue($this->likeService, $this->posts[$i]->id);

            $response = $this->likeService->countLike();
            $this->assertSame($likes_num, $response);
        }
    }

    /**
     * 存在しない外部キー名を引数とする
     *
     * @return void
     */
    public function testArgumentIsAForeignKeyThatDoesNotExist(): void
    {
        $foreignKey = 'not existent foreign key';
        foreach ($this->posts as $post) {
            $this->setLikes($post);
            $this->assertThrows(
                fn () => $this->likeService->countLike($foreignKey, $post->id),
                QueryException::class
            );
        }
    }

    /**
     * 外部キー名未定義
     *
     * @return void
     */
    public function testForeignKeyUndefined(): void
    {
        foreach ($this->posts as $post) {
            $this->setLikes($post);
            $this->assertThrows(
                fn () => $this->likeService->countLike(postId: $post->id),
                TypeError::class
            );
        }
    }

    /**
     * メンバ変数の foreignKey に値が代入された状態で外部キー名未定義
     *
     * @return void
     */
    public function testForeignKeyUndefinedWithValueAssignedToMemberVariableForeignKey(): void
    {
        for ($i = 0; $i < count(ThreadsConst::USED_FOREIGN_KEYS); $i++) {
            $likes_num = $this->setLikes($this->posts[$i]);
            $this->propertyForeignKey
                ->setValue($this->likeService, ThreadsConst::USED_FOREIGN_KEYS[$i]);

            $response = $this->likeService->countLike(postId: $this->posts[$i]->id);
            $this->assertSame($likes_num, $response);
        }
    }

    /**
     * メンバ変数の postId に値が代入された状態で外部キー名未定義
     *
     * @return void
     */
    public function testForeignKeyUndefinedWithValueAssignedToMemberVariablePostId(): void
    {
        for ($i = 0; $i < count(ThreadsConst::USED_FOREIGN_KEYS); $i++) {
            $likes_num = $this->setLikes($this->posts[$i]);
            $this->propertyPostId
                ->setValue($this->likeService, $this->posts[$i]->id);

            $this->assertThrows(
                fn () => $this->likeService->countLike(postId: $this->posts[$i]->id),
                TypeError::class
            );
        }
    }

    /**
     * メンバ変数に値が代入された状態で外部キー名未定義
     *
     * @return void
     */
    public function testForeignKeyUndefinedWithValueAssignedToMemberVariable(): void
    {
        for ($i = 0; $i < count(ThreadsConst::USED_FOREIGN_KEYS); $i++) {
            $likes_num = $this->setLikes($this->posts[$i]);
            $this->propertyForeignKey
                ->setValue($this->likeService, ThreadsConst::USED_FOREIGN_KEYS[$i]);
            $this->propertyPostId
                ->setValue($this->likeService, $this->posts[$i]->id);

            $response = $this->likeService->countLike(postId: $this->posts[$i]->id);
            $this->assertSame($likes_num, $response);
        }
    }

    /**
     * 存在しない書き込みIDを引数とする
     *
     * @return void
     */
    public function testArgumentIsAPostIdThatDoesNotExist(): void
    {
        $postId = -1;
        for ($i = 0; $i < count($this->posts); $i++) {
            $this->setLikes($this->posts[$i]);
            $response = $this->likeService->countLike(
                ThreadsConst::USED_FOREIGN_KEYS[$i],
                $postId
            );
            $this->assertSame(0, $response);
        }
    }

    /**
     * 書き込みID未定義
     *
     * @return void
     */
    public function testPostIdUndefined(): void
    {
        for ($i = 0; $i < count($this->posts); $i++) {
            $this->setLikes($this->posts[$i]);
            $this->assertThrows(
                fn () => $this->likeService->countLike(foreignKey: ThreadsConst::USED_FOREIGN_KEYS[$i]),
                TypeError::class
            );
        }
    }

    /**
     * メンバ変数の foreignKey に値が代入された状態で書き込みID未定義
     *
     * @return void
     */
    public function testPostIdUndefinedWithValueAssignedToMemberVariableForeignKey(): void
    {
        for ($i = 0; $i < count(ThreadsConst::USED_FOREIGN_KEYS); $i++) {
            $likes_num = $this->setLikes($this->posts[$i]);
            $this->propertyForeignKey
                ->setValue($this->likeService, ThreadsConst::USED_FOREIGN_KEYS[$i]);

            $this->assertThrows(
                fn () => $this->likeService->countLike(foreignKey: ThreadsConst::USED_FOREIGN_KEYS[$i]),
                TypeError::class
            );
        }
    }

    /**
     * メンバ変数の postId に値が代入された状態で書き込みID未定義
     *
     * @return void
     */
    public function testPostIdUndefinedWithValueAssignedToMemberVariablePostId(): void
    {
        for ($i = 0; $i < count(ThreadsConst::USED_FOREIGN_KEYS); $i++) {
            $likes_num = $this->setLikes($this->posts[$i]);
            $this->propertyPostId
                ->setValue($this->likeService, $this->posts[$i]->id);

            $response = $this->likeService->countLike(foreignKey: ThreadsConst::USED_FOREIGN_KEYS[$i]);
            $this->assertSame($likes_num, $response);
        }
    }

    /**
     * メンバ変数に値が代入された状態で書き込みID未定義
     *
     * @return void
     */
    public function testPostIdUndefinedWithValueAssignedToMemberVariable(): void
    {
        for ($i = 0; $i < count(ThreadsConst::USED_FOREIGN_KEYS); $i++) {
            $likes_num = $this->setLikes($this->posts[$i]);
            $this->propertyForeignKey
                ->setValue($this->likeService, ThreadsConst::USED_FOREIGN_KEYS[$i]);
            $this->propertyPostId
                ->setValue($this->likeService, $this->posts[$i]->id);

            $response = $this->likeService->countLike(foreignKey: ThreadsConst::USED_FOREIGN_KEYS[$i]);
            $this->assertSame($likes_num, $response);
        }
    }
}
