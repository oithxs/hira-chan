<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Rules\Password;

trait PasswordValidationRules
{
    /**
     * パスワードの検証に使用する検証ルールを取得する
     *
     * @link https://jetstream.laravel.com/2.x/features/authentication.html
     * @link https://readouble.com/laravel/9.x/ja/validation.html
     *
     * @return array
     */
    protected function passwordRules()
    {
        return ['required', 'string', new Password, 'confirmed'];
    }
}
