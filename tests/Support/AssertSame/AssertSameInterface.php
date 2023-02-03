<?php

namespace Tests\Support\AssertSame;

interface AssertSameInterface
{
    /**
     * 対象データの全要素を取得する
     *
     * @return array
     */
    function getKeysExpected(): array;

    /**
     * 対象データの実データを取得する
     *
     * @param array $args
     * @return array
     */
    function getValuesActual(array $args): array;

    /**
     * 対象データの期待するデータを取得する
     *
     * @param array $args
     * @return array
     */
    function getValuesExpected(array $args): array;
}
