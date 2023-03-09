<?php

namespace Tests\Support;

class Random
{
    /**
     * 0~9の文字を利用してランダムな文字列を生成する
     *
     * @param integer $length 文字列の長さ
     * @return string ランダムな文字列（すべて数字）
     */
    public static function stringOfNumbers(int $length = 10): string
    {
        $str = '';
        while (strlen($str) < $length) {
            $str .= (string) random_int(0, 9);
        }
        return $str;
    }

    /**
     * 指定した配列の要素から，指定された文字長の文字列を生成する
     *
     * @param array $strings ランダムな文字列生成
     * @param integer $length 生成する文字長
     * @return string ランダムな文字列
     */
    public static function base(array $strings, int $length): string
    {
        $str = '';
        while (strlen($str) < $length) {
            $str .= $strings[random_int(0, count($strings) - 1)];
        }
        return $str;
    }

    /**
     * 指定された文字長のランダムな英文字・記号・数字の文字列を生成する
     *
     * @param integer $length 生成する文字長
     * @return string ランダムな英文字・記号・数字の文字列
     */
    public static function string(int $length = 10): string
    {
        return self::base(range('!', '~'), $length);
    }

    /**
     * 指定された文字長のランダムな英小文字の文字列を生成する
     *
     * @param integer $length 生成する文字長
     * @return string ランダムな英小文字の文字列
     */
    public static function lowercase(int $length = 10): string
    {
        return self::base(range('a', 'z'), $length);
    }

    /**
     * 指定された文字長のランダムな英大文字の文字長を生成する
     *
     * @param integer $length 生成する文字長
     * @return string ランダムな英大文字の文字列
     */
    public static function uppercase(int $length = 10): string
    {
        return self::base(range('A', 'Z'), $length);
    }

    /**
     * 指定された文字長のランダムな英字の文字列を生成する
     *
     * @param integer $length 生成する文字長
     * @return string ランダムな英字の文字列
     */
    public static function english(int $length = 10): string
    {
        return self::base(array_merge(
            range('A', 'Z'),
            range('a', 'z')
        ), $length);
    }

    /**
     * 指定された文字長のランダムな記号の文字列を生成する
     *
     * @param integer $length 生成する文字長
     * @return string ランダムな記号の文字列
     */
    public static function symbol(int $length = 10): string
    {
        return self::base(array_merge(
            range('!', '/'),
            range(':', '@'),
            range('[', '`'),
            range('{', '~')
        ), $length);
    }
}
