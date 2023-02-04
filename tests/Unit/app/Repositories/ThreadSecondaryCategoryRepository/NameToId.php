<?php

namespace Tests\Unit\app\Repositories\ThreadSecondaryCategoryRepository;

use App\Consts\Tables\ThreadPrimaryCategoryConst;
use App\Consts\Tables\ThreadSecondaryCategoryConst;
use App\Models\ThreadSecondaryCategory;
use App\Repositories\ThreadSecondaryCategoryRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use TypeError;

class NameToId extends TestCase
{
    use RefreshDatabase;

    /**
     * @var array テスト対象のメソッド
     */
    private array $method;

    public function setUp(): void
    {
        parent::setUp();

        // メンバ変数に値を代入する
        $this->method = [new ThreadSecondaryCategoryRepository, 'nameToId'];
    }

    /**
     * 詳細カテゴリ名から対応する詳細カテゴリのIDを取得する
     *
     * @param string $secondaryCategoryName 詳細カテゴリ名
     * @return integer 対応する詳細カテゴリのID
     */
    public function getThreadSecondaryCategoryId(string $secondaryCategoryName): int
    {
        return ThreadSecondaryCategory::where('name', $secondaryCategoryName)->first()->id;
    }

    /**
     * 詳細カテゴリのIDを取得できることをアサートする
     *
     * @return void
     */
    public function testAssertThatTheIdOfTheSecondaryCategoryCanBeObtained(): void
    {
        foreach (ThreadSecondaryCategoryConst::SECONDARY_CATEGORYS as $secondaryCategoryName) {
            $this->assertSame(
                $this->getThreadSecondaryCategoryId($secondaryCategoryName),
                ($this->method)($secondaryCategoryName)
            );
        }
    }

    /**
     * 存在しない詳細カテゴリ名を引数とする
     *
     * @return void
     */
    public function testArgumentThatAThreadSecondaryCategoryNameThatDoesNotExists(): void
    {
        $threadSecondaryCategoryName = 'not existent thread secondary category name';
        $this->assertSame(
            null,
            ($this->method)($threadSecondaryCategoryName)
        );
    }

    /**
     * 詳細カテゴリ名未定義
     *
     * @return void
     */
    public function testThreadSecondaryCategoryNameUNdefined(): void
    {
        $this->assertThrows(
            fn () => ($this->method)(),
            TypeError::class
        );
    }
}
