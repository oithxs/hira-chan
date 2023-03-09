<?php

namespace Tests\Unit\app\Services\ThreadService;

use App\Consts\Tables\ThreadsConst;
use App\Services\ThreadService;
use PHPUnit\Framework\TestCase;
use TypeError;

class GetTableNameTest extends TestCase
{
    /**
     * 取得したモデルのテーブル名をアサートする
     *
     * @return void
     */
    public function testAssertsTheTableNameOfTheRetrievedModel(): void
    {
        for ($i = 0; $i < count(ThreadsConst::TABLES); $i++) {
            $response = (new ThreadService)->getTableName(ThreadsConst::CATEGORYS[$i]);
            $this->assertSame(
                ThreadsConst::TABLES[$i],
                $response
            );
        }
    }

    /**
     * 存在しない大枠カテゴリを引数とする
     *
     * @return void
     */
    public function testArgumentIsAThreadPrimaryCategoryNameThatDoseNotExist(): void
    {
        $threadPrimaryCategoryName = 'not existent thread primary category';
        $response = (new ThreadService)->getTableName($threadPrimaryCategoryName);
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
        $response = (new ThreadService)->getTableName();
        $this->assertSame('', $response);
    }
}
