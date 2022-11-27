<?php

namespace App\Http\Requests\Login;

use App\Actions\Fortify\PasswordValidationRules;
use Laravel\Jetstream\Jetstream;

/**
 * This class is not used as a form request.
 * This class is for validation and output messages of '\App\Actions\Fortify\CreateNewUser.php'.
 */
class CreateNewUserRequest
{
    use PasswordValidationRules;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules applied to the user creation.
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
     * Get a custom message for validator errors during user creation.
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
     * Get the validation rules applied to the user restoration.
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
     * Get a custom message for validator errors during user restore.
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
