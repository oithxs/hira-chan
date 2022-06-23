<?php

namespace Laravel\Fortify\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Laravel\Fortify\Fortify;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            Fortify::username() => [
                'required',
                'string',
                'max:255',
                'unique:users',
                'regex:/^e1[a-z]\d{5}$/'
            ],
            'password' => 'required|string',
        ];
    }

    public function messages()
    {
        $username = Fortify::username();

        return [
            "$username.max:255" => "学生番号は例の様に入力して下さい",
            "$username.regex" => '学生番号は例の様に入力して下さい'
        ];
    }
}
