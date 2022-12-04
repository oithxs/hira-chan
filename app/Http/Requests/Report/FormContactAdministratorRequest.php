<?php

namespace App\Http\Requests\Report;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class FormContactAdministratorRequest extends FormRequest
{
    /**
     * ユーザーがこの要求を行う権限があるかどうかを判断する．
     *
     * @link https://readouble.com/laravel/9.x/ja/validation.html
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * リクエストに適用されるバリデーションルールを取得．
     *
     * @link https://readouble.com/laravel/9.x/ja/validation.html
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'radio_1' => 'required',
            'report_form_textarea' => 'required | max:15000'
        ];
    }

    /**
     * バリデータエラー用のカスタムメッセージを取得する．
     *
     * @link https://readouble.com/laravel/9.x/ja/validation.html
     *
     * @return array
     */
    public function messages()
    {
        return [
            'radio_1.required' => 'どのような内容かを選択して下さい',
            'report_form_textarea.required' => '詳しい内容を入力して下さい',
            'report_form_textarea.max' => '15000文字以内で入力して下さい'
        ];
    }

    /**
     * バリデーションの失敗を処理する．
     *
     * @link https://laravel.com/api/9.x/Illuminate/Foundation/Http/FormRequest.html#method_failedValidation
     * @todo 上記のリンクをメソッドの説明付きの良さげなURLに置き換える
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        $response['errors']  = $validator->errors();

        throw new HttpResponseException(response()->json($response));
    }
}
