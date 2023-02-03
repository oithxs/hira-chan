<?php

namespace App\Consts\Tables;

class ThreadsConst
{
    // カラム名
    const ID = 'id';
    const HUB_ID = HubConst::USED_FOREIGN_KEY;
    const USER_ID = UserConst::USED_FOREIGN_KEY;
    const MESSAGE_ID = 'message_id';
    const MESSAGE = 'message';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const DELETED_AT = 'deleted_at';

    // 大枠カテゴリ一覧
    const CATEGORYS = [
        ThreadPrimaryCategoryConst::CLUB,
        ThreadPrimaryCategoryConst::COLLEGE_YEAR,
        ThreadPrimaryCategoryConst::DEPARTMENT,
        ThreadPrimaryCategoryConst::JOB_HUNTING,
        ThreadPrimaryCategoryConst::LECTURE,
    ];

    // モデル名を key として，大枠カテゴリ名を value とした連想配列
    const MODEL_TO_CATEGORYS = [
        self::MODEL_FQCNS[0] => self::CATEGORYS[0],
        self::MODEL_FQCNS[1] => self::CATEGORYS[1],
        self::MODEL_FQCNS[2] => self::CATEGORYS[2],
        self::MODEL_FQCNS[3] => self::CATEGORYS[3],
        self::MODEL_FQCNS[4] => self::CATEGORYS[4],
    ];

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

    // Eloquentモデルまでの完全修飾クラス名
    const MODEL_FQCNS = [
        ClubThreadConst::MODEL_FQCN,
        CollegeYearThreadConst::MODEL_FQCN,
        DepartmentThreadConst::MODEL_FQCN,
        JobHuntingThreadConst::MODEL_FQCN,
        LectureThreadConst::MODEL_FQCN,
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

    // モデル名を key として，テーブルが外部キーとして利用される時のカラム名を value とした連想配列
    const MODEL_TO_USED_FOREIGN_KEYS = [
        self::MODEL_FQCNS[0] => self::USED_FOREIGN_KEYS[0],
        self::MODEL_FQCNS[1] => self::USED_FOREIGN_KEYS[1],
        self::MODEL_FQCNS[2] => self::USED_FOREIGN_KEYS[2],
        self::MODEL_FQCNS[3] => self::USED_FOREIGN_KEYS[3],
        self::MODEL_FQCNS[4] => self::USED_FOREIGN_KEYS[4],
    ];
}
