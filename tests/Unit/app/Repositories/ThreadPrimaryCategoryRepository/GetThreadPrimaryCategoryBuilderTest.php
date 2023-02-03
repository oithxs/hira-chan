<?php

namespace Tests\Unit\app\Repositories\ThreadPrimaryCategoryRepository;

use App\Consts\Tables\ThreadsConst;
use App\Repositories\ThreadPrimaryCategoryRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\AssertSame\AssertSameInterface;
use Tests\Support\AssertSame\Tables\ThreadPrimaryCategoryTrait;
use Tests\TestCase;
use TypeError;

class GetThreadPrimaryCategoryBuilderTest extends TestCase implements AssertSameInterface
{
    use RefreshDatabase,
        ThreadPrimaryCategoryTrait;

    /**
     * テスト対象のメソッド
     *
     * @var array
     */
    private array $method;

    public function setUp(): void
    {
        parent::setUp();

        // メンバ変数に値を代入する
        $this->method = [new ThreadPrimaryCategoryRepository, 'getThreadPrimaryCategoryBuilder'];
    }

    /**
     * 期待する大枠カテゴリ名を返却する
     *
     * @param array $args
     * @return array
     */
    public function getValuesExpected(array $args): array
    {
        $expected = [];
        $expected['name'] = $args['primaryCategoryName'];
        return $expected;
    }

    /**
     * 大枠カテゴリが取得できることをアサートする
     *
     * @return void
     */
    public function testAssertThatAPrimaryCategoryCanBeObtained(): void
    {
        foreach (ThreadsConst::CATEGORYS as $primaryCategoryName) {
            $response = ($this->method)($primaryCategoryName);
            $this->threadPrimaryCategory = $response->first()->toArray();

            $this->assertTrue($response instanceof Builder);
            $this->assertSame($this->getKeysExpected(), array_keys($this->threadPrimaryCategory));
            $this->assertSame(
                $this->getValuesExpected(['primaryCategoryName' => $primaryCategoryName]),
                $this->getValuesActual()
            );
        }
    }

    /**
     * 存在しない大枠カテゴリ名を引数とする
     *
     * @return void
     */
    public function testArgumentIsAPrimaryCategoryNameIdThatDoesNotExist(): void
    {
        $primaryCategoryName = 'not existent thread category name';
        $response = ($this->method)($primaryCategoryName);
        $this->threadPrimaryCategory = $response->get()->toArray();

        $this->assertTrue($response instanceof Builder);
        $this->assertSame([], $this->threadPrimaryCategory);
    }

    /**
     * 大枠カテゴリ名未定義
     *
     * @return void
     */
    public function testPrimaryCategoryNameUndefined(): void
    {
        $this->assertThrows(
            fn () => ($this->method)(),
            TypeError::class
        );
    }
}
