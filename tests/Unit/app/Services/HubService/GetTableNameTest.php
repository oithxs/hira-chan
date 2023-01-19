<?php

namespace Tests\Unit\app\Services\HubService;

use App\Consts\Tables\ThreadsConst;
use App\Services\HubService;
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
            $response = (new HubService)->getTableName(ThreadsConst::CATEGORYS[$i]);
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
        $response = (new HubService)->getTableName($threadPrimaryCategoryName);
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
        $response = (new HubService)->getTableName();
        $this->assertSame('', $response);
    }
}
