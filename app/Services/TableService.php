<?php

namespace App\Services;

class TableService
{
    /**
     * 外部キー名を作成する
     *
     * 文字列の最後に '_id' を結合して返却する
     *
     * @param string $tableName テーブル名
     * @return string 引数の最後に '_id' を追加した文字列
     */
    public function makeForeignKeyName(string $tableName): string
    {
        return $this->pluralToSingular($tableName) . '_id';
    }

    /**
     * 最後の文字が 's' であればそれを削除する
     *
     * @param string $str 加工を行う文字列
     * @return string 引数の最後の 's' を削除した文字列
     */
    public function pluralToSingular(string $str): string
    {
        return preg_replace("/s$/", '', $str);
    }
}
