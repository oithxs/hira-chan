<?php

namespace App\Actions\Fortify;

use App\Http\Requests\Login\CreateNewUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    /**
     * 新規に登録されたユーザーを検証し，作成する．
     *
     * @link https://jetstream.laravel.com/2.x/features/registration.html
     * @link https://readouble.com/laravel/9.x/ja/migrations.html
     * @link https://readouble.com/laravel/9.x/ja/validation.html
     * @link https://readouble.com/laravel/9.x/ja/queries.html
     *
     * @see \App\Http\Requests\Login\CreateNewUserRequest::storeRules() [Call]
     * @see \App\Http\Requests\Login\CreateNewUserRequest::storeMessages() [Call]
     * @see \App\Http\Requests\Login\CreateNewUserRequest::reStoreRules() [Call]
     * @see \App\Http\Requests\Login\CreateNewUserRequest::reStoreMessages() [Call]
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        $form_request = new CreateNewUserRequest();
        $input['email'] .= "@st.oit.ac.jp";

        // 論理削除されたユーザの復元
        if (User::onlyTrashed()->where('email', '=', $input['email'])->first()) {
            Validator::make($input, $form_request->reStoreRules(), $form_request->reStoreMessages())->validate();
            User::onlyTrashed()->where('email', '=', $input['email'])->restore();
            User::where('email', '=', $input['email'])->update([
                'name' => $input['name'],
                'password' => Hash::make($input['password']),
                'email_verified_at' => null,
                'two_factor_secret' => null,
                'two_factor_recovery_codes' => null,
                'two_factor_confirmed_at' => null,
                'remember_token' => null,
                'current_team_id' => null,
                'profile_photo_path' => null
            ]);
            return User::where('email', '=', $input['email'])->first();
        }

        // ユーザ登録
        Validator::make($input, $form_request->storeRules(), $form_request->storeMessages())->validate();
        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
