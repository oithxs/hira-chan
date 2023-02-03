<?php

namespace Tests\Support\AssertSame\Tables;

use App\Consts\Tables\ThreadSecondaryCategoryConst;
use Tests\Support\ArrayToolsTrait;

trait ThreadSecondaryCategoryTrait
{
    use ArrayToolsTrait;

    /**
     * 対応する thread_secondary_categorys テーブルのデータ
     *
     * @var array
     */
    public array $threadSecondaryCategory;

    /**
     * thread_secondary_categorys テーブルのすべてのカラム名を期待する値として取得する
     *
     * @return array
     */
    public function getKeysExpected(): array
    {
        return ThreadSecondaryCategoryConst::COLUMNS;
    }

    /**
     * thread_secondary_categorys テーブルの一部のカラムのデータを実際の値として返却する
     *
     * @param array|null $args
     * @return array
     */
    public function getValuesActual(array $args = null): array
    {
        return $this->getArrayElement($this->threadSecondaryCategory, [
            'thread_primary_category_id',
            'name',
        ]);
    }
}
