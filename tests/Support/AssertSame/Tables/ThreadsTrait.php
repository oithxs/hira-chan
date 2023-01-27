<?php

namespace Tests\Support\AssertSame\Tables;

use App\Consts\Tables\ThreadsConst;
use Tests\Support\ArrayToolsTrait;

trait ThreadsTrait
{
    use ArrayToolsTrait;

    /**
     * 対応する
     * club_threads, college_year_threads, department_threads,
     * job_hunting_threads, lecture_threads
     * テーブルいずれかのデータ
     *
     * @var array
     */
    public array $post;

    /**
     * club_threads, college_year_threads, department_threads,
     * job_hunting_threads, lecture_threads
     * テーブルに共通するすべてのカラム名を期待する値として取得する
     *
     * @return array
     */
    public function getKeysExpected(): array
    {
        return ThreadsConst::COLUMNS;
    }

    /**
     * club_threads, college_year_threads, department_threads,
     * job_hunting_threads, lecture_threads
     * テーブルの一部のカラムのデータを実際の値として返却する
     *
     * @param array|null $args
     * @return array
     */
    public function getValuesActual(array $args = null): array
    {
        return $this->getArrayElement($this->post, [
            'hub_id',
            'user_id',
            'message_id',
            'message',
        ]);
    }
}
