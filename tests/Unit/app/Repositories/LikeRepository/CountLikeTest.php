<?php

namespace Tests\Unit\app\Repositories\LikeRepository;

use App\Consts\Tables\ThreadsConst;
use App\Models\Like;
use App\Models\ThreadModel;
use App\Repositories\LikeRepository;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\PostTestTrait;
use Tests\TestCase;
use TypeError;

class CountLikeTest extends TestCase
{
    use PostTestTrait,
        RefreshDatabase;

    /**
     * @var array テスト対象のメソッド
     */
    private array $method;

    public function setUp(): void
    {
        parent::setUp();
        $this->postSetUp();

        // メンバ変数に値を代入する
        $this->method = [new LikeRepository, 'countLike'];
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

            $response = ($this->method)(
                ThreadsConst::USED_FOREIGN_KEYS[$i],
                $this->posts[$i]->id
            );
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
                fn () => ($this->method)($foreignKey, $post->id),
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
                fn () => ($this->method)(postId: $post->id),
                TypeError::class
            );
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
            $response = ($this->method)(
                ThreadsConst::USED_FOREIGN_KEYS[$i],
                $postId
            );
            $this->assertSame(0, $response);
        }
    }

    /**
     * 外部キー名未定義
     *
     * @return void
     */
    public function testPostIdUndefined(): void
    {
        for ($i = 0; $i < count($this->posts); $i++) {
            $this->setLikes($this->posts[$i]);
            $this->assertThrows(
                fn () => ($this->method)(foreignKey: ThreadsConst::USED_FOREIGN_KEYS[$i]),
                TypeError::class
            );
        }
    }
}
