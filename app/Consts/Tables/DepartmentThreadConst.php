<?php

namespace App\Consts\Tables;

class DepartmentThreadConst extends ThreadsConst
{
    // 大枠カテゴリ名
    const PRIMARY_CATEGORY_NAME = ThreadPrimaryCategoryConst::DEPARTMENT;

    // Eloquentモデルまでの完全修飾クラス名
    const MODEL_FQCN = '\App\Models\DepartmentThread';

    // テーブル名
    const NAME = 'department_threads';

    // 外部キーとして利用されるときのカラム名
    const USED_FOREIGN_KEY = 'department_thread_id';
}
