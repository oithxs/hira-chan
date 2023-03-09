<?php

namespace Tests\Support\AssertSame\Tables;

use App\Consts\Tables\ThreadPrimaryCategoryConst;
use Tests\Support\ArrayToolsTrait;

trait ThreadPrimaryCategoryTrait
{
    use ArrayToolsTrait;

    /**
     * 対応する thread_primary_categorys テーブルのデータ
     *
     * @var array
     */
    public array $threadPrimaryCategory;

    /**
     * thread_primary_categorys テーブルのすべてのカラム名を期待する値として取得する
     *
     * @return array
     */
    public function getKeysExpected(): array
    {
        return ThreadPrimaryCategoryConst::COLUMNS;
    }

    /**
     * thread_primary_categorys テーブルの一部のカラムのデータを実際の値として返却する
     *
     * @param array|null $args
     * @return array
     */
    public function getValuesActual(array $args = null): array
    {
        return $this->getArrayElement($this->threadPrimaryCategory, [
            'name',
        ]);
    }
}
