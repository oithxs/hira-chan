<?php

namespace App\Services\Support;

class HtmlSpecialCharsService
{
    /**
     * 変換元 key
     * 変換後 value
     *
     * とした連想配列
     */
    const HTML_SPECIAL_CHARACTER = [
        '&' => '&amp;',
        '<' => '&lt;',
        '>' => '&gt;',
        ' ' => '&ensp;',
        '　' => '&emsp;',
        "\n" => '<br>',
        "\t" => '&ensp;&ensp;'
    ];

    /**
     * 元の文字列と同様にHTMLで表示できるように文字列を変換する
     *
     * @param string $text 変換する文字列
     * @return string HTMLで問題なく表示できるように変換した文字列
     */
    public static function encode(string $text): string
    {
        foreach (self::HTML_SPECIAL_CHARACTER as $key => $value) {
            $text = str_replace($key, $value, $text);
        }
        return $text;
    }
}
