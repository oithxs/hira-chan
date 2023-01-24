<?php

namespace Tests\Unit\app\Services\TableService;

use App\Services\TableService;
use Illuminate\Support\Str;
use PHPUnit\Framework\TestCase;
use TypeError;

class PluralToSingularTest extends TestCase
{
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
        $this->method = [new TableService, 'pluralToSingular'];
    }

    /**
     * 文字列の最後の「s」が削除されていることをアサートする
     *
     * @return void
     */
    public function testAssertsThatTheLastSInTheStringHasBeenDeleted(): void
    {
        $str = Str::random(10);
        $strAddS = $str . 's';
        foreach (range(0, 10000) as $_) {
            $this->assertSame($str, ($this->method)($strAddS));
        }
    }

    /**
     * 文字列の最後に「s」がなければ
     * そのままの文字列が返されることをアサートする
     *
     * @return void
     */
    public function testAssertsThatIfThereIsNoTrailingSInTheStringTheStringIsReturnedAsIs(): void
    {
        foreach (range('a', 'z') as $char) {
            if ($char !== 's') {
                $str = Str::random(10) . $char;
                $this->assertSame($str, ($this->method)($str));
            }
        }
    }

    /**
     * 文字列未定義
     *
     * @return void
     */
    public function testStringUndefined(): void
    {
        $this->expectException(TypeError::class);
        ($this->method)();
    }
}
