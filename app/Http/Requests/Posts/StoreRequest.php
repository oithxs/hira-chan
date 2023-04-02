<?php

namespace App\Http\Requests\Posts;

use App\Rules\MaxLineRule as max_line;
use App\Rules\TrimRule as trim;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreRequest extends FormRequest
{
    /**
     * ユーザーがこの要求を行う権限があるかどうかを判断する．
     *
     * @return boolean
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * リクエストに適用されるバリデーションルールを取得．
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'thread_id' => 'required|regex:/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/',
            'reply' => 'integer|nullable',
            'message' => ['nullable', 'required_without:img', 'string', new trim(), 'max:800', new max_line(20)],
            'img' => ['nullable', 'required_without:message', 'image', 'mimes:bmp,gif,jpg,jpeg,png,webp', 'max:3000'],
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
        $response = response()->json(
            [$validator->errors()],
            422,
            [],
            JSON_UNESCAPED_UNICODE
        );

        throw new HttpResponseException($response);
    }
}
