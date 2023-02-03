<?php

namespace Tests\Unit\app\Repositories\ThreadPrimaryCategoryRepository;

use App\Consts\Tables\ThreadsConst;
use App\Consts\Tables\ThreadSecondaryCategoryConst;
use App\Models\ThreadPrimaryCategory;
use App\Repositories\ThreadPrimaryCategoryRepository;
use Error;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\AssertSame\AssertSameInterface;
use Tests\Support\AssertSame\Tables\ThreadSecondaryCategoryTrait;
use Tests\TestCase;
use TypeError;

class GetThreadSecondaryCategoryHasManyTest extends TestCase implements AssertSameInterface
{
    use RefreshDatabase,
        ThreadSecondaryCategoryTrait;

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
        $this->method = [new ThreadPrimaryCategoryRepository, 'getThreadSecondaryCategoryHasMany'];
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
        $expected['thread_primary_category_id'] = $this->getThreadPrimaryCategoryId($args['primaryCategoryName']);
        $expected['name'] = $args['secondaryCategoryName'];
        return $expected;
    }

    /**
     * 対応する大枠カテゴリIDを取得する
     *
     * @param string $primaryCategoryName 大枠カテゴリ名
     * @return integer
     */
    private function getThreadPrimaryCategoryId(string $primaryCategoryName): int
    {
        return ThreadPrimaryCategory::where('name', $primaryCategoryName)->first()->id;
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
            $this->assertTrue($response instanceof HasMany);
            $response = $response->get();

            for ($i = 0; $i < count($response); $i++) {
                $this->threadSecondaryCategory = $response[$i]->toArray();

                $this->assertSame($this->getKeysExpected(), array_keys($this->threadSecondaryCategory));
                $this->assertSame(
                    $this->getValuesExpected([
                        'primaryCategoryName' => $primaryCategoryName,
                        'secondaryCategoryName' => ThreadSecondaryCategoryConst::SECONDARY_CATEGORYS[$primaryCategoryName][$i],
                    ]),
                    $this->getValuesActual()
                );
            }
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
        $this->assertThrows(
            fn () => ($this->method)($primaryCategoryName),
            Error::class
        );
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
