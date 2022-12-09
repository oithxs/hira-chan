<?php

namespace App\Actions\Fortify;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\ResetsUserPasswords;

class ResetUserPassword implements ResetsUserPasswords
{
    use PasswordValidationRules;

    /**
     * パスワードリセット画面で入力された値を検証し，パスワードのリセット（再登録）を行う．
     *
     * パスワードリセットの際にこのクラスが実行されている訳ではなさそう．
     *
     * @link https://jetstream.laravel.com/2.x/features/authentication.html
     * @link https://readouble.com/laravel/8.x/ja/passwords.html
     * @link https://readouble.com/laravel/9.x/ja/queries.html
     * @link https://readouble.com/laravel/9.x/ja/validation.html
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function reset($user, array $input)
    {
        Validator::make($input, [
            'password' => $this->passwordRules(),
        ])->validate();

        $user->forceFill([
            'password' => Hash::make($input['password']),
        ])->save();
    }
}
