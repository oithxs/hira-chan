<?php

namespace Tests\Unit\app\Services\Support\HtmlSpecialCharsService;

use App\Services\Support\HtmlSpecialCharsService;
use PHPUnit\Framework\TestCase;

class EncodeTest extends TestCase
{
    /**
     * 文字列を変換する
     *
     * @return void
     */
    public function test_converting_strings(): void
    {
        $text = <<<EOF
&<> 　spaces
	Tab
EOF;

        $expectedText = <<<EOF
&amp;&lt;&gt;&ensp;&emsp;spaces<br>&ensp;&ensp;Tab
EOF;

        $response = HtmlSpecialCharsService::encode($text);
        $this->assertSame($expectedText, $response);
    }
}
