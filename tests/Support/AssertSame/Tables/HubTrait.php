<?php

namespace Tests\Support\AssertSame\Tables;

use App\Consts\Tables\HubConst;
use Tests\Support\ArrayToolsTrait;

trait HubTrait
{
    use ArrayToolsTrait;

    /**
     * @var array 期待するhubテーブルのデータ
     */
    public array $hub;

    /**
     * hub テーブルすべてのカラム名を期待する値として取得する
     *
     * @return array hubテーブルのすべてのカラム名
     */
    public function getKeysExpected(): array
    {
        return HubConst::COLUMNS;
    }

    /**
     * hub テーブルの一部のカラムのデータを実際の値として返却する
     *
     * @param array|null $args 引数は使用しない
     * @return array hubテーブルの一部のカラムのデータ
     */
    public function getValuesActual(array $args = null): array
    {
        return $this->getArrayElement($this->hub, [
            'thread_secondary_category_id',
            'user_id',
            'name',
        ]);
    }
}
