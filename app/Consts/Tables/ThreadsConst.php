<?php

namespace App\Consts\Tables;

class ThreadsConst
{
    // カラム名
    const ID = 'id';
    const HUB_ID = 'hub_id';
    const USER_ID = 'user_id';
    const MESSAGE_ID = 'message_id';
    const MESSAGE = 'message';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const DELETED_AT = 'deleted_at';

    // カラム一覧
    const COLUMNS = [
        self::ID,
        self::HUB_ID,
        self::USER_ID,
        self::MESSAGE_ID,
        self::MESSAGE,
        self::CREATED_AT,
        self::UPDATED_AT,
        self::DELETED_AT,
    ];

    // スレッドへの書き込みを保存するテーブル一覧
    const TABLES = [
        ClubThreadConst::NAME,
        CollegeYearThreadConst::NAME,
        DepartmentThreadConst::NAME,
        JobHuntingThreadConst::NAME,
        LectureThreadConst::NAME,
    ];

    // テーブルが外部キーとして利用される時のカラム名
    const USED_FOREIGN_KEYS = [
        ClubThreadConst::USED_FOREIGN_KEY,
        CollegeYearThreadConst::USED_FOREIGN_KEY,
        DepartmentThreadConst::USED_FOREIGN_KEY,
        JobHuntingThreadConst::USED_FOREIGN_KEY,
        LectureThreadConst::USED_FOREIGN_KEY,
    ];

    // Eloquentモデルまでの完全修飾クラス名
    const MODEL_FQCNS = [
        ClubThreadConst::MODEL_FQCN,
        CollegeYearThreadConst::MODEL_FQCN,
        DepartmentThreadConst::MODEL_FQCN,
        JobHuntingThreadConst::MODEL_FQCN,
        LectureThreadCOnst::MODEL_FQCN,
    ];
}
