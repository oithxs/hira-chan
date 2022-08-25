<?php

namespace App\Http\Requests\report;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class FormContactAdministratorRequest extends FormRequest
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
     * Get custom messages for validator errors.
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
     * Handle a failed validation attempt.
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
