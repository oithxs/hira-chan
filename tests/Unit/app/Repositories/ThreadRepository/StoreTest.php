<?php

namespace Tests\Unit\app\Repositories\ThreadRepository;

use App\Consts\Tables\ThreadsConst;
use App\Models\Hub;
use App\Models\ThreadPrimaryCategory;
use App\Models\ThreadSecondaryCategory;
use App\Models\User;
use App\Repositories\ThreadRepository;
use Error;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;
use TypeError;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    /**
     * すべてのカテゴリのスレッド
     *
     * @var array
     */
    private array $threads;

    /**
     * メッセージID
     *
     * @var integer
     */
    private int $messageId;

    /**
     * 保存したメッセージ
     *
     * @var array
     */
    private array $messages;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        foreach (ThreadsConst::CATEGORYS as $category) {
            $this->threads[] = Hub::factory([
                'thread_secondary_category_id' => ThreadSecondaryCategory::where(
                    'thread_primary_category_id',
                    ThreadPrimaryCategory::where('name', $category)->first()->id
                )->first()->id
            ])->create();
        }
        $this->messageId = 1;
        $this->messages = [];
        if (count(ThreadsConst::CATEGORYS) !== count($this->threads)) {
            $this->assertTrue(false);
        }
    }

    /**
     * スレッドに書き込みをするテストで期待される戻り値（key）を取得する
     *
     * @return array
     */
    private function getKeysExpected(): array
    {
        return ThreadsConst::COLUMNS;
    }

    /**
     * スレッドに書き込みをするテストで期待される戻り値（value）を取得する
     *
     * @param integer $i
     * @param integer $j
     * @return array
     */
    private function getValuesExpected(int $i, int $j): array
    {
        $expected = [];
        $expected['hub_id'] = $this->threads[$i]->id . '';
        $expected['user_id'] = $this->user->id . '';
        $expected['message_id'] = $this->messageId++;
        $expected['message'] = $this->messages[$j];
        return $expected;
    }

    /**
     * スレッドに書き込みをするテストで実際に保存されているデータを取得する
     *
     * @param integer $i
     * @param integer $j
     * @return array
     */
    private function getValuesActual(int $i, int $j): array
    {
        $post = $this->getPost($i, $j);
        return $this->getArrayElement($post, [
            'hub_id',
            'user_id',
            'message_id',
            'message'
        ]);
    }

    /**
     * スレッド書き込み用テーブルに保存された対応するデータを取得する
     *
     * @param integer $i
     * @param integer $j
     * @return array|null
     */
    private function getPost(int $i, int $j = 0): array | null
    {
        $post = THreadsConst::MODEL_FQCNS[$i]::where([
            ['hub_id', $this->threads[$i]->id],
            ['message', $this->messages[$j]]
        ])
            ->first();
        return $post ? $post->toArray() : null;
    }

    /**
     * 渡された配列のうち，指定したインデックスの要素を返却する
     *
     * @param array $ary 連想配列
     * @param array $keys 連想配列のインデックスを指定
     * @return array インデックスと一致した連想配列を返却
     */
    private function getArrayElement(array $ary, array $keys): array
    {
        $post = [];
        foreach ($keys as $key) {
            $post[$key] = $ary[$key];
        }
        return $post;
    }

    /**
     * スレッドに投稿されたメッセージのデータをアサートする
     *
     * @return void
     */
    public function testAssertTheDataOfTheMessagePostedToTheThread(): void
    {
        for ($i = 0; $i < count(ThreadsConst::CATEGORYS); $i++) {
            $this->messageId = 1;
            $this->messages = [];
            $postMin = 0;
            $postMax = 9;
            foreach (range($postMin, $postMax) as $_) {
                $this->messages[] = Str::uuid() . '';
                ThreadRepository::store(
                    ThreadsConst::MODEL_FQCNS[$i],
                    $this->threads[$i]->id,
                    $this->user->id,
                    $this->messages[count($this->messages) - 1]
                );
            }

            foreach (range($postMin, $postMax) as $j) {
                $this->assertSame($this->getKeysExpected(), array_keys($this->getPost($i, $j)));
                $this->assertSame($this->getValuesExpected($i, $j), $this->getValuesActual($i, $j));
            }
        }
    }

    /**
     * 存在しないモデルの完全修飾クラス名を引数とする
     *
     * @return void
     */
    public function testArgumentIsAModelFqcnThatDoseNotExist(): void
    {
        $modelFQCN = 'not existent model FQCN';
        $threadId = 'not existent thread id'; // 存在しないスレッド用テーブルでスレッドの作成はできない
        $this->messageId = 1;
        $this->messages[] = Str::uuid() . '';
        $this->assertThrows(
            fn () =>
            ThreadRepository::store(
                $modelFQCN,
                $threadId,
                $this->user->id,
                $this->messages[count($this->messages) - 1]
            ),
            Error::class
        );
    }


    /**
     * 存在しないスレッドIDを引数とする
     *
     * @return void
     */
    public function testArgumentIsAThreadIdThatDoseNotExist(): void
    {
        $threadId = 'not existent thread id';
        for ($i = 0; $i < count(ThreadsConst::CATEGORYS); $i++) {
            $this->messageId = 1;
            $this->messages[] = Str::uuid() . '';

            $this->assertThrows(
                fn () => ThreadRepository::store(
                    ThreadsConst::MODEL_FQCNS[$i],
                    $threadId,
                    $this->user->id,
                    $this->messages[count($this->messages) - 1]
                ),
                QueryException::class
            );

            $this->assertSame(null, $this->getPost($i));
        }
    }

    /**
     * 存在しないユーザIDを引数とする
     *
     * @return void
     */
    public function testArgumentIsAUserIdThatDoseNotExist(): void
    {
        $userId = 'not existent user id';
        for ($i = 0; $i < count(ThreadsConst::CATEGORYS); $i++) {
            $this->messageId = 1;
            $this->messages[] = Str::uuid() . '';

            $this->assertThrows(
                fn () => ThreadRepository::store(
                    ThreadsConst::MODEL_FQCNS[$i],
                    $this->threads[$i]->id,
                    $userId,
                    $this->messages[count($this->messages) - 1]
                ),
                QueryException::class
            );

            $this->assertSame(null, $this->getPost($i));
        }
    }

    /**
     * モデルまでの完全修飾クラス名未定義
     *
     * @return void
     */
    public function testModelFqcnUndefined(): void
    {
        $threadId = 'not existent thread id';
        $message = fake()->text;
        $this->assertThrows(
            fn () => ThreadRepository::store(
                null,
                $threadId,
                $this->user->id,
                $message
            ),
            TypeError::class
        );

        foreach (ThreadsConst::MODEL_FQCNS as $modelFQCN) {
            $this->assertSame([], $modelFQCN::get()->toArray());
        }
    }

    /**
     * スレッドID未定義
     *
     * @return void
     */
    public function testThreadIdUndefined(): void
    {
        for ($i = 0; $i < count(ThreadsConst::CATEGORYS); $i++) {
            $message = fake()->text;
            $this->assertThrows(
                fn () => ThreadRepository::store(
                    ThreadsConst::MODEL_FQCNS[$i],
                    null,
                    $this->user->id,
                    $message
                ),
                TypeError::class
            );
        }

        foreach (ThreadsConst::MODEL_FQCNS as $modelFQCN) {
            $this->assertSame([], $modelFQCN::get()->toArray());
        }
    }

    /**
     * ユーザID未定義
     *
     * @return void
     */
    public function testUserIdUndefined(): void
    {
        for ($i = 0; $i < count(ThreadsConst::CATEGORYS); $i++) {
            $message = fake()->text;
            $this->assertThrows(
                fn () => ThreadRepository::store(
                    ThreadsConst::MODEL_FQCNS[$i],
                    $this->threads[$i]->id,
                    null,
                    $message
                ),
                TypeError::class
            );
        }

        foreach (ThreadsConst::MODEL_FQCNS as $modelFQCN) {
            $this->assertSame([], $modelFQCN::get()->toArray());
        }
    }

    /**
     * メッセージ未定義
     *
     * @return void
     */
    public function testMessageUndefined(): void
    {
        for ($i = 0; $i < count(ThreadsConst::CATEGORYS); $i++) {
            $message = fake()->text;
            $this->assertThrows(
                fn () => ThreadRepository::store(
                    ThreadsConst::MODEL_FQCNS[$i],
                    $this->threads[$i]->id,
                    $this->user->id,
                    null
                ),
                TypeError::class
            );
        }

        foreach (ThreadsConst::MODEL_FQCNS as $modelFQCN) {
            $this->assertSame([], $modelFQCN::get()->toArray());
        }
    }
}
