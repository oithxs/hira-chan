<?php

namespace App\Consts\Tables;

use App\Models\JobHuntingThread;

class JobHuntingThreadConst extends ThreadsConst
{
    // 大枠カテゴリ名
    const PRIMARY_CATEGORY_NAME = ThreadPrimaryCategoryConst::JOB_HUNTING;

    // Eloquentモデルまでの完全修飾クラス名
    const MODEL_FQCN = JobHuntingThread::class;

    // テーブル名
    const NAME = 'job_hunting_threads';

    // 外部キーとして利用されるときのカラム名
    const USED_FOREIGN_KEY = 'job_hunting_thread_id';
}
