<?php

namespace App\Actions\Fortify;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * 指定されたユーザーのプロファイル情報を検証し，更新する．
     *
     * 'email'は変更を禁止している
     * 'photo'はそもそも不明
     *
     * @link https://jetstream.laravel.com/2.x/features/profile-management.html
     * @link https://readouble.com/laravel/9.x/ja/validation.html
     * @link https://readouble.com/laravel/9.x/ja/queries.html
     *
     * @param mixed $user
     * @param array $input ['id', 'user_page_theme_id', 'name', 'email', 'email_verified_at',
     *                      'two_factor_confirmed_at', 'current_team_id', 'profile_photo_path',
     *                      'created_at', 'updated_at', 'deleted_at', 'profile_photo_url']
     * @return void
     */
    public function update($user, array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if (
            $input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail
        ) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
            ])->save();
        }
    }

    /**
     * 指定された認証ユーザーのプロファイル情報を更新する．
     *
     * @param mixed $user
     * @param array $input ['id', 'user_page_theme_id', 'name', 'email', 'email_verified_at',
     *                      'two_factor_confirmed_at', 'current_team_id', 'profile_photo_path',
     *                      'created_at', 'updated_at', 'deleted_at', 'profile_photo_url']
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
