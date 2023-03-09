<?php

namespace Tests\Unit\app\Services\ThreadService;

use App\Consts\Tables\ThreadsConst;
use App\Services\ThreadService;
use PHPUnit\Framework\TestCase;
use TypeError;

class GetThreadClassNameTest extends TestCase
{
    /**
     * 取得したモデルの完全修飾クラス名をアサートする
     *
     * @return void
     */
    public function testAssertsTheFqcnOfTheRetrievedModel(): void
    {
        for ($i = 0; $i < count(ThreadsConst::TABLES); $i++) {
            $response = (new ThreadService)->getThreadClassName(ThreadsConst::CATEGORYS[$i]);
            $this->assertSame(
                ThreadsConst::MODEL_FQCNS[$i],
                $response
            );
        }
    }

    /**
     * 存在しない大枠カテゴリ名を引数とする
     *
     * @return void
     */
    public function testArgumentIsAThreadPrimaryCategoryNameThatDoseNotExist(): void
    {
        $threadPrimaryCategoryName = 'not existent thread primary category';
        $response = (new ThreadService)->getThreadClassName($threadPrimaryCategoryName);
        $this->assertSame('', $response);
    }

    /**
     * 大枠カテゴリ名未定義
     *
     * @return void
     */
    public function testThreadPrimaryCategoryNameUndefined(): void
    {
        $this->expectException(TypeError::class);
        $response = (new ThreadService)->getThreadClassName();
        $this->assertSame('', $response);
    }
}
