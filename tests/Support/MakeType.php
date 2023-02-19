<?php

namespace Tests\Support;

class MakeType
{
    /**
     * resourceをのぞいたすべての型を生成する
     *
     * @link https://www.php.net/manual/ja/language.types.intro.php
     *
     * @return array
     */
    public static function all(): array
    {
        $types = [];
        $types['null'] = null;
        $types['bool'] = random_int(0, 1) === 1 ? true : false;
        $types['int'] = random_int(PHP_INT_MIN, PHP_INT_MAX);
        $types['float'] = random_int(PHP_INT_MIN, PHP_INT_MAX) / PHP_INT_MAX * 1.0;
        $types['string'] = Random::string();
        $types['array'] = [Random::string()];
        $types['object'] = new MakeType;
        $types['callable'] = fn () => null;
        // $types['resource] =
        return $types;
    }

    /**
     * 指定された型の要素をのぞいた配列を返却する
     *
     * @param string|array $ignores 除外する要素のkey
     * @return array $ignoresの型をのぞいた，すべての型を要素とした配列
     */
    public static function ignores(string | array $ignores): array
    {
        $types = self::all();

        if (is_string($ignores)) {
            unset($types[$ignores]);
        }

        if (is_array($ignores)) {
            foreach ($ignores as $ignore) {
                unset($types[$ignore]);
            }
        }

        return $types;
    }
}
