<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService
{
    /**
     * ユーザページテーマの更新
     *
     * @param string $userId 更新するユーザのID
     * @param integer $userPageTheme 更新するページテーマのID
     * @return void
     */
    public function updateUserPageTheme(string $userId, int $userPageThemeId): void
    {
        UserRepository::updateUserPageTheme($userId, $userPageThemeId);
    }
}
