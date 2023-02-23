<?php

namespace App\Repositories;

use App\Models\ContactType;

class ContactTypeRepository
{
    /**
     * お問い合わせの種類名からそのIDを取得する
     *
     * @param string $name お問い合わせの種類名
     * @return integer お問い合わせの種類ID
     */
    public static function getIdByName(string $name): int
    {
        return ContactType::where('name', $name)->first()->id;
    }
}
