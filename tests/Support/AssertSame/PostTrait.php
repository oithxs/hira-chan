<?php

namespace Tests\Support\AssertSame;

use Tests\Support\ArrayToolsTrait;
use Tests\Support\AssertSame\Tables\ThreadsTrait;

/**
 * テーブルから取得した要素に加えて，
 * コントローラで書き込みを取得した際に追加されるいくつかの要素を追加
 */
trait PostTrait
{
    use ArrayToolsTrait,
        ThreadsTrait {
        ThreadsTrait::getKeysExpected as getThreadKeysExpected;
        ThreadsTrait::getValuesActual as getThreadValuesActual;
    }

    /**
     * 実際の書き込み
     *
     * @var array
     */
    public array $post;

    /**
     * 書き込みを取得した際に期待する key を取得する
     *
     * @return array
     */
    public function getKeysExpected(): array
    {
        $expected = $this->getThreadKeysExpected();
        $expected[] = 'likes_count';
        $expected[] = 'user';
        $expected[] = 'thread_image_path';
        $expected[] = 'likes';
        return $expected;
    }

    /**
     * 実際に取得した書き込みを返却する
     *
     * @return array
     */
    public function getValuesActual(array $args = null): array
    {
        // テーブルから取得したデータに追加する要素
        $postActualKeys = [
            'likes_count',
            'user',
            'thread_image_path',
            'likes',
        ];

        $actual = $this->getThreadValuesActual();
        foreach ($postActualKeys as $postActualKey) {
            $actual[$postActualKey] = $this->post[$postActualKey];
        }
        return $actual;
    }
}
