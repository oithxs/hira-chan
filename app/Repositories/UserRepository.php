<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    /**
     * ユーザページテーマの更新
     *
     * @param string $userId 更新するユーザのID
     * @param integer $userPageTheme 更新するページテーマのID
     * @return void
     */
    public static function updateUserPageTheme(string $userId, int $userPageThemeId): void
    {
        User::where('id', '=', $userId)->update([
            'user_page_theme_id' => $userPageThemeId
        ]);
    }
}
