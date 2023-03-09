<?php

namespace App\Services;

use App\Repositories\ContactAdministratorRepository;
use App\Repositories\ContactTypeRepository;

class ContactAdministratorService
{
    /**
     * ユーザからの報告・問い合わせを保存する
     *
     * @param string $contactTypeName 報告・問い合わせの種類
     * @param string $userId 報告・問い合わせを行ったユーザ
     * @param string $message 詳細な内容
     * @return void
     */
    public function store(string $contactTypeName, string $userId, string $message): void
    {
        ContactAdministratorRepository::store(
            ContactTypeRepository::getIdByName($contactTypeName),
            $userId,
            $message
        );
    }
}
