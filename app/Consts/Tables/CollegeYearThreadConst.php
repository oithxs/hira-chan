<?php

namespace App\Consts\Tables;

use App\Models\CollegeYearThread;

class CollegeYearThreadConst extends ThreadsConst
{
    // 大枠カテゴリ名
    const PRIMARY_CATEGORY_NAME = ThreadPrimaryCategoryConst::COLLEGE_YEAR;

    // Eloquentモデルまでの完全修飾クラス名
    const MODEL_FQCN = CollegeYearThread::class;

    // テーブル名
    const NAME = 'college_year_threads';

    // 外部キーとして利用されるときのカラム名
    const USED_FOREIGN_KEY = 'college_year_thread_id';
}
