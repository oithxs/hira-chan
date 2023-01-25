<?php

namespace Tests\Support;

trait ArrayToolsTrait
{
    /**
     * 渡された配列のうち，指定したインデックスの要素を返却する
     *
     * @param array $ary 連想配列
     * @param array $keys 連想配列のインデックスを指定
     * @return array インデックスと一致した連想配列を返却
     */
    public static function getArrayElement(array $ary, array $keys): array
    {
        $response = [];
        foreach ($keys as $key) {
            $response[$key] = $ary[$key];
        }
        return $response;
    }
}
