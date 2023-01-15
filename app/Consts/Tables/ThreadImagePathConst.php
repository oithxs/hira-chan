<?php

namespace App\Consts\Tables;

class ThreadImagePathConst
{
    // テーブル名
    const NAME = 'access_logs';

    // カラム名
    const ID = 'id';
    const CLUB_THREAD_ID = 'club_thread_id';
    const COLLEGE_YEAR_THREAD_ID = 'college_year_thread_id';
    const DEPARTMENT_THREAD_ID = 'department_thread_id';
    const JOB_HUNTING_THREAD_ID = 'job_hunting_thread_id';
    const LECTURE_THREAD_ID = 'lecture_thread_id';
    const USER_ID = 'user_id';
    const IMG_PATH = 'img_path';
    const IMG_SIZE = 'img_size';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    // カラム一覧
    const COLUMNS = [
        self::ID,
        self::CLUB_THREAD_ID,
        self::COLLEGE_YEAR_THREAD_ID,
        self::DEPARTMENT_THREAD_ID,
        self::JOB_HUNTING_THREAD_ID,
        self::LECTURE_THREAD_ID,
        self::USER_ID,
        self::IMG_PATH,
        self::IMG_SIZE,
        self::CREATED_AT,
        self::UPDATED_AT,
    ];
}
