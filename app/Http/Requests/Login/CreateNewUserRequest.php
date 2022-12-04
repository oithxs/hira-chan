<?php

namespace App\Http\Requests\Login;

use App\Actions\Fortify\PasswordValidationRules;
use Laravel\Jetstream\Jetstream;

/**
 * このクラスはFormRequestとして使用しない．
 * このクラスは，「\App\Actions\Fortify\CreateNewUser.php」のバリデーションと出力メッセージに使用する．
 */
class CreateNewUserRequest
{
    use PasswordValidationRules;

    /**
     * ユーザーがこの要求を行う権限があるかどうかを判断する．
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * ユーザー作成に適用されるバリデーションルールを取得する．
     *
     * @see \App\Actions\Fortify\CreateNewUser::create() [Called]
     *
     * @return array<string, mixed>
     */
    public function storeRules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'unique:users', 'regex:/^e1[a-z]\d{5}@st.oit.ac.jp$/'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ];
    }

    /**
     * ユーザー作成時のバリデータエラーに対するカスタムメッセージを取得する．
     *
     * @see \App\Actions\Fortify\CreateNewUser::create() [Called]
     *
     * @return array
     */
    public function storeMessages(): array
    {
        return [
            'name.max' => '名前は255文字以内で入力して下さい',
            'email.max' => '学生番号は例の様に入力して下さい',
            'email.unique' => '学生番号が重複しています',
            'email.regex' => '学生番号は例の様に入力して下さい'
        ];
    }

    /**
     * ユーザー復元に適用されるバリデーションルールを取得する．
     *
     * @see \App\Actions\Fortify\CreateNewUser::create() [Called]
     *
     * @return array<string, mixed>
     */
    public function reStoreRules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'regex:/^e1[a-z]\d{5}@st.oit.ac.jp$/'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ];
    }

    /**
     * ユーザー復元時のバリデータエラーに対応するカスタムメッセージを取得する．
     *
     * @see \App\Actions\Fortify\CreateNewUser::create() [Called]
     *
     * @return array
     */
    public function reStoreMessages(): array
    {
        return [
            'name.max' => '名前は255文字以内で入力して下さい',
            'email.max' => '学生番号は例の様に入力して下さい',
            'email.regex' => '学生番号は例の様に入力して下さい'
        ];
    }
}
