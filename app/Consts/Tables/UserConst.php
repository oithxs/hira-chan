<?php

namespace App\Consts\Tables;

class UserConst
{
    // テーブル名
    const NAME = 'users';

    // 外部キーとして利用されるときのカラム名
    const USED_FOREIGN_KEY = 'user_id';

    // カラム名
    const ID = 'id';
    const USER_PAGE_THEME_ID = UserPageThemeConst::USED_FOREIGN_KEY;
    const _NAME = 'name';
    const EMAIL = 'email';
    const EMAIL_VERIFIED_AT = 'email_verified_at';
    const PASSWORD = 'password';
    const TWO_FACTOR_SECRET = 'two_factor_secret';
    const TWO_FACTOR_RECOVERY_CODES = 'two_factor_recovery_codes';
    const TWO_FACTOR_CONFIRMED_AT = 'two_factor_confirmed_at';
    const REMEMBER_TOKEN = 'remember_token';
    const CURRENT_TEAM_ID = 'current_team_id';
    const PROFILE_PHOTO_PATH = 'profile_photo_path';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const DELETED_AT = 'deleted_at';

    // カラム一覧
    const COLUMNS = [
        self::ID,
        self::USER_PAGE_THEME_ID,
        self::_NAME,
        self::EMAIL,
        self::EMAIL_VERIFIED_AT,
        self::PASSWORD,
        self::TWO_FACTOR_SECRET,
        self::TWO_FACTOR_RECOVERY_CODES,
        self::TWO_FACTOR_CONFIRMED_AT,
        self::REMEMBER_TOKEN,
        self::CURRENT_TEAM_ID,
        self::PROFILE_PHOTO_PATH,
        self::CREATED_AT,
        self::UPDATED_AT,
        self::DELETED_AT,
    ];
}
