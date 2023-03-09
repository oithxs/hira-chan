<?php

namespace App\Actions\Fortify;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;

class UpdateUserPassword implements UpdatesUserPasswords
{
    use PasswordValidationRules;

    /**
     * ユーザーのパスワードを検証し，更新する．
     *
     * @link https://jetstream.laravel.com/2.x/features/password-update.html
     * @link https://readouble.com/laravel/9.x/ja/validation.html
     * @link https://readouble.com/laravel/9.x/ja/queries.html
     *
     * @param  mixed  $user
     * @param  array  $input ['current_password', 'password', 'password_confirmation']
     * @return void
     */
    public function update($user, array $input)
    {
        Validator::make($input, [
            'current_password' => ['required', 'string'],
            'password' => $this->passwordRules(),
        ])->after(function ($validator) use ($user, $input) {
            if (!isset($input['current_password']) || !Hash::check($input['current_password'], $user->password)) {
                $validator->errors()->add('current_password', __('The provided password does not match your current password.'));
            }
        })->validateWithBag('updatePassword');

        $user->forceFill([
            'password' => Hash::make($input['password']),
        ])->save();
    }
}
