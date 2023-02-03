<?php

namespace App\Consts\Tables;

class ThreadSecondaryCategoryConst
{
    // テーブル名
    const NAME = 'thread_secondary_categorys';

    // 外部キーとして利用されるときのカラム名
    const USED_FOREIGN_KEY = 'thread_secondary_category_id';

    // カラム名
    const ID = 'id';
    const THREAD_PRIMARY_CATEGORY_ID = ThreadPrimaryCategoryConst::USED_FOREIGN_KEY;
    const _NAME = 'name';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    // カラム一覧
    const COLUMNS = [
        self::ID,
        self::THREAD_PRIMARY_CATEGORY_ID,
        self::_NAME,
        self::CREATED_AT,
        self::UPDATED_AT,
    ];

    // php artisan db:seed を実行後に保存されるデータ
    // 部活
    const HXS = 'HxSコンピュータ部';

    // 学年
    const FRESHMAN = '1年生';
    const SOPHOMORE = '2年生';
    const JUNIOR = '3年生';
    const SENIOR = '4年生';

    // 学科
    const _ID = 'ID科';
    const IC = 'IC科';
    const IS = 'IS科';
    const IM = 'IM科';
    const IN = 'IN科';

    // 就職
    const TWENTY_TWENTY_TWO = '2022年度';

    // 授業
    const CAREER_COURSES = 'キャリア科目';

    /*
    | 大枠カテゴリカテゴリをkeyとして
    | それに属する詳細カテゴリの配列を値とする連想配列
    */
    const PRIMARY_IN_SECONDARY_CATEGORYS = [
        ThreadPrimaryCategoryConst::CLUB => [
            self::HXS,
        ],
        ThreadPrimaryCategoryConst::COLLEGE_YEAR => [
            self::FRESHMAN,
            self::SOPHOMORE,
            self::JUNIOR,
            self::SENIOR,
        ],
        ThreadPrimaryCategoryConst::DEPARTMENT => [
            self::_ID,
            self::IC,
            self::IS,
            self::IM,
            self::IN,
        ],
        ThreadPrimaryCategoryConst::JOB_HUNTING => [
            self::TWENTY_TWENTY_TWO,
        ],
        ThreadPrimaryCategoryConst::LECTURE => [
            self::CAREER_COURSES,
        ],
    ];

    // 保存された詳細カテゴリ名一覧
    const SECONDARY_CATEGORYS = [
        self::HXS,
        self::FRESHMAN,
        self::SOPHOMORE,
        self::JUNIOR,
        self::SENIOR,
        self::_ID,
        self::IC,
        self::IS,
        self::IM,
        self::IN,
        self::TWENTY_TWENTY_TWO,
        self::CAREER_COURSES,
    ];
}
