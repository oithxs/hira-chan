<?php

namespace Tests\Unit\app\Repositories\ThreadRepository;

use App\Consts\Tables\ThreadPrimaryCategoryConst;
use App\Models\Hub;
use App\Models\ThreadPrimaryCategory;
use App\Models\ThreadSecondaryCategory;
use App\Repositories\ThreadRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\ArrayTools;
use Tests\Support\AssertSame;
use Tests\Support\TestPost;
use Tests\TestCase;
use TypeError;

class PostToThreadPrimaryCategoryTest extends TestCase implements AssertSame
{
    use RefreshDatabase,
        TestPost,
        ArrayTools;

    /**
     * テースト対象のメソッド
     *
     * @var array
     */
    private array $method;

    public function setUp(): void
    {
        parent::setUp();
        $this->postSetUp();

        // メンバ変数に値を代入する
        $this->method = [new ThreadRepository, 'postToThreadPrimaryCategory'];
    }

    /**
     * thread_primary_category テーブルのすべてのカラム名を期待する値として返却する
     *
     * @return array
     */
    public function getKeysExpected(): array
    {
        return ThreadPrimaryCategoryConst::COLUMNS;
    }

    /**
     * thread_primary_category テーブルの，
     * 一部のカラムに対応させたデータを実際の値として返却する
     *
     * @param array $args
     * @return array
     */
    public function getValuesActual(array $args): array
    {
        return $this->getArrayElement($args['response'], [
            'name'
        ]);
    }

    /**
     * thread_primary_category テーブルの，一部のカラムのデータを実際の値として返却する
     *
     * @param array $args
     * @return array
     */
    public function getValuesExpected(array $args): array
    {
        $expected = [];
        $expected['name'] = $this->getThreadPrimaryCategoryName($args['i']);
        return $expected;
    }

    /**
     * 書き込みに対応する hub テーブルのデータを返却する
     *
     * @param integer $i
     * @return Hub
     */
    private function getHub(int $i): Hub
    {
        return Hub::find($this->posts[$i]->hub_id . '');
    }

    /**
     * 書き込みに対応する thread_primary_category のデータを返却する
     *
     * @param integer $i
     * @return ThreadSecondaryCategory
     */
    private function getThreadSecondaryCategory(int $i): ThreadSecondaryCategory
    {
        return $this->getHub($i)->thread_secondary_category;
    }

    /**
     * 書き込みに対応する thread_primary_category を返却する
     *
     * @param integer $i
     * @return string
     */
    private function getThreadPrimaryCategory(int $i): ThreadPrimaryCategory
    {
        return $this->getThreadSecondaryCategory($i)->thread_primary_category;
    }

    /**
     * 書き込みに対応する thread_primary_category の名前を返却する
     *
     * @param integer $i
     * @return void
     */
    private function getThreadPrimaryCategoryName(int $i)
    {
        return $this->getThreadPrimaryCategory($i)->name;
    }

    /**
     * 取得した大枠カテゴリをアサートする
     *
     * @return void
     */
    public function testAssertsTheThreadPrimaryCategoryRetrievedFromThePost(): void
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
