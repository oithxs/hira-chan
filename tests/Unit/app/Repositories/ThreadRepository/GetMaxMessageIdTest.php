<?php

namespace Tests\Unit\app\Repositories\ThreadRepository;

use App\Consts\Tables\ThreadsConst;
use App\Models\Hub;
use App\Models\ThreadPrimaryCategory;
use App\Models\ThreadSecondaryCategory;
use App\Repositories\ThreadRepository;
use Error;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use TypeError;

class GetMaxMessageIdTest extends TestCase
{
    use RefreshDatabase;

    /**
     * すべてのカテゴリのスレッド
     *
     * @var array
     */
    private array $threads;

    /**
     * 最大書き込み数（message_id）
     *
     * @var integer
     */
    private int $maxMessageId;

    public function setUp(): void
    {
        parent::setUp();

        // メンバ変数に値を代入する
        $this->maxMessageId = 10; // random_int(1, 999); // スレッドに書き込める範囲でランダム
        foreach (ThreadsConst::CATEGORYS as $category) {
            $this->threads[] = Hub::factory([
                'thread_secondary_category_id' => ThreadSecondaryCategory::where(
                    'thread_primary_category_id',
                    ThreadPrimaryCategory::where('name', $category)->first()->id
                )->first()->id
            ])->create();
        }

        // スレッドにメッセージを書き込む
        foreach (range(1, $this->maxMessageId) as $_) {
            for ($i = 0; $i < count(ThreadsConst::MODEL_FQCNS); $i++) {
                ThreadsConst::MODEL_FQCNS[$i]::factory([
                    'hub_id' => $this->threads[$i]->id,
                    'message_id' => ThreadsConst::MODEL_FQCNS[$i]::where([
                        ['hub_id', '=', $this->threads[$i]->id]
                    ])
                        ->max('message_id') + 1
                ])->create();
            }
        }

        // 下記の条件が満たされなければそもそもテストを行わない
        if (count(ThreadsConst::CATEGORYS) !== count($this->threads)) {
            $this->assertTrue(false);
        }
    }

    /**
     * スレッドの最大メッセージIDを取得できることをアサートする
     *
     * @return void
     */
    public function testAssertThatTheMaximumMessageIdOfTheThreadCanBeObtained(): void
    {
        for ($i = 0; $i < count(ThreadsConst::MODEL_FQCNS); $i++) {
            $this->assertSame(
                $this->maxMessageId,
                ThreadRepository::getMaxMessageId(
                    ThreadsConst::MODEL_FQCNS[$i],
                    $this->threads[$i]->id
                )
            );
        }
    }

    /**
     * 存在しないモデルの完全修飾クラス名を引数とする
     *
     * @return void
     */
    public function testArgumentIsAModelFqcnThatDoseNotExist(): void
    {
        $modelFQCN = 'not existent model fqcn';
        for ($i = 0; $i < count(ThreadsConst::MODEL_FQCNS); $i++) {
            $this->assertThrows(
                fn () => ThreadRepository::getMaxMessageId(
                    $modelFQCN,
                    $this->threads[$i]->id
                ),
                Error::class
            );
        }
    }

    /**
     * 存在しないスレッドIDを引数とする
     *
     * @return void
     */
    public function testArgumentIsAThreadIdThatDoseNotExist(): void
    {
        $threadId = 'not existent thread id';
        for ($i = 0; $i < count(ThreadsConst::MODEL_FQCNS); $i++) {
            $this->assertSame(
                null,
                ThreadRepository::getMaxMessageId(
                    ThreadsConst::MODEL_FQCNS[$i],
                    $threadId
                )
            );
        }
    }

    /**
     * モデルまでの完全修飾クラス名未定義
     *
     * @return void
     */
    public function testModelFqcnUndefined(): void
    {
        $modelFQCN = 'not existent model fqcn';
        for ($i = 0; $i < count(ThreadsConst::MODEL_FQCNS); $i++) {
            $this->assertThrows(
                fn () => ThreadRepository::getMaxMessageId(
                    null,
                    $this->threads[$i]->id
                ),
                TypeError::class
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
                fn () => ThreadRepository::getMaxMessageId(
                    ThreadsConst::MODEL_FQCNS[$i],
                    null
                ),
                TypeError::class
            );
        }
    }
}
