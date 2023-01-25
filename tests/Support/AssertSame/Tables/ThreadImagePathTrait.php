<?php

namespace Tests\Support\AssertSame\Tables;

use App\Consts\Tables\ThreadImagePathConst;
use App\Consts\Tables\ThreadsConst;

trait ThreadImagePathTrait
{
    /**
     * 対応する thread_image_paths テーブルのデータ
     *
     * @var array
     */
    public array $threadImagePath;

    /**
     * thread_image_paths テーブルのすべてのカラム名を期待する値として取得する
     *
     * @return array
     */
    function getKeysExpected(): array
    {
        return ThreadImagePathConst::COLUMNS;
    }

    /**
     * thread_image_paths テーブルの一途のカラムのデータを実際の値として返却する
     *
     * @param array|null $args
     * @return array
     */
    public function getValuesActual(array $args = null): array
    {
        return $this->getArrayElement(
            $this->threadImagePath,
            array_merge(ThreadsConst::USED_FOREIGN_KEYS, [
                'user_id',
                'img_path',
                'img_size',
            ])
        );
    }
}
