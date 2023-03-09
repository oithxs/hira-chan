<?php

namespace Laravel\Fortify\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Laravel\Fortify\Fortify;

/**
 * vendorフォルダ内のファイルをオーバーライドする．
 *
 * @see composer.json [autoload.exclude-from-classmap, autoload.files]
 * @todo このファイルは手探りで変更したので，公式のドキュメントが見つけられなかった．
 *       見つけ次第，参考リンクを追加する．
 */
class LoginRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            Fortify::username() => [
                'required',
                'string',
                'max:255',
                'regex:/^e1[a-z]\d{5}$/'
            ],
            'password' => 'required|string',
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
        $username = Fortify::username();

        return [
            "$username.max:255" => '学生番号は例の様に入力して下さい',
            "$username.regex" => '学生番号は例の様に入力して下さい'
        ];
    }
}
