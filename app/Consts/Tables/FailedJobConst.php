<?php

namespace App\Consts\Tables;

class FailedJobConst
{
    // テーブル名
    const NAME = 'failed_jobs';

    // 外部キーとして利用されるときのカラム名
    const USED_FOREIGN_KEY = 'failed_job_id';
}
