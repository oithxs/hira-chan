<?php

namespace Tests\Support\AssertSame\Tables;

use App\Consts\Tables\LikeConst;
use Tests\Support\ArrayToolsTrait;

trait LikeTrait
{
    use ArrayToolsTrait;

    /**
     * @var array 実際のlikeテーブルのデータ
     */
    public array $like;

    /**
     * likes テーブルのすべてのカラム名を期待する値として取得する
     *
     * @return array hubsテーブルのすべてのカラム名
     */
    public function getKeysExpected(): array
    {
        return LikeConst::COLUMNS;
    }

    /**
     * likes テーブルの実際の値を取得する
     *
     * @param array|null $args 値は使用しない
     * @return array likesテーブルの実際のデータ
     */
    public function getValuesActual(array $args = null): array
    {
        return $this->getArrayElement($this->like, [
            LikeConst::CLUB_THREAD_ID,
            LikeConst::COLLEGE_YEAR_THREAD_ID,
            LikeConst::DEPARTMENT_THREAD_ID,
            LikeConst::JOB_HUNTING_THREAD_ID,
            LikeConst::LECTURE_THREAD_ID,
            LikeConst::USER_ID,
        ]);
    }
}
