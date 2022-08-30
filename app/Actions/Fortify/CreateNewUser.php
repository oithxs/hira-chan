<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        $input['email'] .= "@st.oit.ac.jp";
        if (User::onlyTrashed()->where('email', '=', $input['email'])->first()) {
            Validator::make($input, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'max:255', 'regex:/^e1[a-z]\d{5}@st.oit.ac.jp$/'],
                'password' => $this->passwordRules(),
                'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
            ], [
                'name.max' => '名前は255文字以内で入力して下さい',
                'email.max' => '学生番号は例の様に入力して下さい',
                'email.regex' => '学生番号は例の様に入力して下さい'
            ])->validate();

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
        } else {
            Validator::make($input, [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'max:255', 'unique:users', 'regex:/^e1[a-z]\d{5}@st.oit.ac.jp$/'],
                'password' => $this->passwordRules(),
                'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
            ], [
                'name.max' => '名前は255文字以内で入力して下さい',
                'email.max' => '学生番号は例の様に入力して下さい',
                'email.unique' => '学生番号が重複しています',
                'email.regex' => '学生番号は例の様に入力して下さい'
            ])->validate();

            return User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ]);
        }
    }
}
