<?php

namespace Tests\Unit\app\Repositories\ThreadRepository;

use App\Consts\Tables\ThreadSecondaryCategoryConst;
use App\Models\ThreadPrimaryCategory;
use App\Models\ThreadSecondaryCategory;
use App\Repositories\ThreadRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\ArrayToolsTrait;
use Tests\Support\AssertSameInterface;
use Tests\Support\PostTestTrait;
use Tests\TestCase;
use TypeError;

class PostToThreadSecondaryCategoryTest extends TestCase implements AssertSameInterface
{
    use RefreshDatabase,
        PostTestTrait,
        ArrayToolsTrait;

    /**
     * テースト対象のメソッド
     *
     * @var array
     */
    private array $method;

    public function setUp(): void
    {
        parent::setUp();
        $this->allSecondaryCategoryPostSetUp();

        // メンバ変数に値を代入
        $this->method = [new ThreadRepository, 'postToThreadSecondaryCategory'];
    }

    /**
     * thread_secondary_category テーブルのすべてのカラムを期待する値として取得する
     *
     * @return array
     */
    public function getKeysExpected(): array
    {
        return ThreadSecondaryCategoryConst::COLUMNS;
    }

    /**
     * thread_secondary_category テーブルの一部のカラムのデータを実際の値として返却する
     *
     * @param array $args
     * @return array
     */
    public function getValuesActual(array $args): array
    {
        return $this->getArrayElement($args['response'], [
            'thread_primary_category_id',
            'name',
        ]);
    }

    /**
     * thread_secondary_category テーブルの一部のカラムのデータを期待する値として返却する
     *
     * @param array $args
     * @return array
     */
    public function getValuesExpected(array $args): array
    {
        $expected = [];
        $expected[ThreadSecondaryCategoryConst::COLUMNS[1]] = (int) $this->getThreadPrimaryCategoryId($args['i']);
        $expected[ThreadSecondaryCategoryConst::COLUMNS[2]] = $this->getThreadSecondaryCategoryName($args['i']);
        return $expected;
    }

    /**
     * thread_secondary_category テーブルの対応するデータを取得する
     *
     * @param integer $i
     * @return ThreadSecondaryCategory
     */
    private function getThreadSecondaryCategory(int $i): ThreadSecondaryCategory
    {
        return ThreadSecondaryCategory::find($this->posts[$i]->hub->thread_secondary_category_id);
    }

    /**
     * thread_secondary_category テーブルの対応する詳細カテゴリ名を取得する
     *
     * @param integer $i
     * @return string
     */
    private function getThreadSecondaryCategoryName(int $i): string
    {
        return $this->getThreadSecondaryCategory($i)->name;
    }

    /**
     * thread_primary_category テーブルの対応するデータを取得する
     *
     * @param integer $i
     * @return ThreadPrimaryCategory
     */
    private function getThreadPrimaryCategory(int $i): ThreadPrimaryCategory
    {
        return $this->getThreadSecondaryCategory($i)->thread_primary_category;
    }

    /**
     * thread_primary_category テーブルの対応するIDを取得する
     *
     * @param integer $i
     * @return string
     */
    private function getThreadPrimaryCategoryId(int $i): string
    {
        return $this->getThreadPrimaryCategory($i)->id;
    }

    /**
     * 取得した詳細カテゴリをアサートする
     *
     * @return void
     */
    public function testAssertsTheThreadSecondaryCategoryRetrievedFromThePost(): void
    {
        for ($i = 0; $i < count($this->posts); $i++) {
            $response = ($this->method)($this->posts[$i])->toArray();
            $this->assertSame($this->getKeysExpected(), array_keys($response));
            $this->assertSame(
                $this->getValuesExpected(['i' => $i]),
                $this->getValuesActual(['response' => $response])
            );
        }
    }

    /**
     * 存在しない書き込みを引数とする
     *
     * @return void
     */
    public function testArgumentIsAPostThatDoseNotExist(): void
    {
        $post = 'not existent post';
        $this->assertThrows(
            fn () => ($this->method)($post),
            TypeError::class
        );
    }

    /**
     * 書き込み未定義
     *
     * @return void
     */
    public function testPostUndefined(): void
    {
        $this->assertThrows(
            fn () => ($this->method)(),
            TypeError::class
        );
    }
}
