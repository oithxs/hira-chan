<?php

namespace Tests\Support\AssertSame\Tables;

use App\Consts\Tables\ContactAdministratorConst;
use Tests\Support\ArrayToolsTrait;

trait ContactAdministratorTrait
{
    use ArrayToolsTrait;

    /**
     * @var array 期待する contact_administrators テーブルのデータ
     */
    public array $contactAdministrator;

    /**
     * contact_administrators テーブルすべてのカラム名を期待する値として取得する
     *
     * @return array contact_administrators テーブルのすべてのカラム名
     */
    public function getKeysExpected(): array
    {
        return ContactAdministratorConst::COLUMNS;
    }

    /**
     * contact_administrators テーブルの一部のカラムのデータを実際の値として取得する
     *
     * @param array|null $args 引数は使用しない
     * @return array contact_administrators テーブルの一部のカラムのデータ
     */
    public function getValuesActual(array $args = null): array
    {
        return $this->getArrayElement($this->contactAdministrator, [
            ContactAdministratorConst::CONTACT_TYPE_ID,
            ContactAdministratorConst::USER_ID,
            ContactAdministratorConst::MESSAGE,
        ]);
    }
}
