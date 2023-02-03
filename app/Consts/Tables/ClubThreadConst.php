<?php

namespace App\Consts\Tables;

use App\Models\ClubThread;

class ClubThreadConst extends ThreadsConst
{
    // 大枠カテゴリ名
    const PRIMARY_CATEGORY_NAME = ThreadPrimaryCategoryConst::CLUB;

    // Eloquentモデルまでの完全修飾クラス名
    const MODEL_FQCN = ClubThread::class;

    // テーブル名
    const NAME = 'club_threads';

    // 外部キーとして利用されるときのカラム名
    const USED_FOREIGN_KEY = 'club_thread_id';
}
