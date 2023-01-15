<?php

namespace App\Consts\Tables;

class LectureThreadConst extends ThreadsConst
{
    const NAME = 'lecture_threads';

    const USED_FOREIGN_KEY = 'lecture_thread_id';

    const MODEL_FQCN = '\App\Models\LectureThread';
}
