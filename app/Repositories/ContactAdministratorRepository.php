<?php

namespace App\Repositories;

use App\Models\ContactAdministrator;

class ContactAdministratorRepository
{
    /**
     * 運営への報告・問い合わせを保存する
     *
     * @param string $contactTypeId 報告・問い合わせのタイプ
     * @param string $userId 報告・問い合わせを行うユーザ
     * @param string $message 報告・問い合わせの詳細な内容
     * @return void なし
     */
    public static function store(string $contactTypeId, string $userId, string $message): void
    {
        ContactAdministrator::create([
            'contact_type_id' => $contactTypeId,
            'user_id' => $userId,
            'message' => $message
        ]);
    }
}
