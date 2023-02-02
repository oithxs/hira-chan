<?php

namespace App\Consts\Tables;

class ThreadImagePathConst
{
    // テーブル名
    const NAME = 'thread_image_paths';

    // 外部キーとして利用されるときのカラム名
    const USED_FOREIGN_KEY = 'thread_image_path_id';

    // カラム名
    const ID = 'id';
    const CLUB_THREAD_ID = ClubThreadConst::USED_FOREIGN_KEY;
    const COLLEGE_YEAR_THREAD_ID = CollegeYearTHreadConst::USED_FOREIGN_KEY;
    const DEPARTMENT_THREAD_ID = DepartmentThreadConst::USED_FOREIGN_KEY;
    const JOB_HUNTING_THREAD_ID = JobHuntingThreadConst::USED_FOREIGN_KEY;
    const LECTURE_THREAD_ID = LectureThreadConst::USED_FOREIGN_KEY;
    const USER_ID = UserConst::USED_FOREIGN_KEY;
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
