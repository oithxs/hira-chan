<?php

namespace Tests\Support\AssertSame\Tables;

use App\Consts\Tables\UserConst;
use Tests\Support\ArrayToolsTrait;

trait UserTrait
{
    use ArrayToolsTrait;

    /**
     * @var array 実際のusersテーブルのデータ
     */
    public array $user;

    /**
     * usersテーブルすべてのカラム名を期待する値として取得する
     *
     * @return array 期待するusersテーブルすべてのカラム名
     */
    public function getKeysExpected(): array
    {
        return UserConst::COLUMNS;
    }

    /**
     * users テーブルの一部のカラムのデータを実際の値として返却する
     *
     * @param array|null $args
     * @return array
     */
    public function getValuesActual(array $args = null): array
    {
        return $this->getArrayElement($this->user, [
            UserConst::USER_PAGE_THEME_ID,
            UserConst::_NAME,
            UserConst::EMAIL,
            UserConst::EMAIL_VERIFIED_AT,
            UserConst::TWO_FACTOR_CONFIRMED_AT,
            UserConst::CURRENT_TEAM_ID,
            UserConst::PROFILE_PHOTO_PATH,
        ]);
    }
}
