<?php

namespace Tests\Unit\app\Services\TableService;

use App\Consts\TableConst;
use App\Services\TableService;
use PHPUnit\Framework\TestCase;
use TypeError;

class MakeForeignKeyNameTest extends TestCase
{
    private array $method;

    public function setUp(): void
    {
        parent::setUp();

        // メンバ変数に値を代入する
        $this->method = [new TableService, 'makeForeignKeyName'];
    }

    /**
     * テーブル名から外部キー名が取得できることをアサートする
     *
     * @return void
     */
    public function testAssertsThatTheForeignKeyNameCanBeObtainedFromTheTableName(): void
    {
        for ($i = 0; $i < count(TableConst::NAMES); $i++) {
            $this->assertSame(
                TableConst::USED_FOREIGN_KEYS[$i],
                ($this->method)(TableConst::NAMES[$i])
            );
        }
    }

    /**
     * テーブル名未定義
     *
     * @return void
     */
    public function testTableNameUndefined(): void
    {
        $this->expectException(TypeError::class);
        ($this->method)();
    }
}
