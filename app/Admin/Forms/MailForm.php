<?php

namespace App\Admin\Forms;

use Encore\Admin\Widgets\Form;
use Illuminate\Http\Request;

class MailForm extends Form
{
    /**
     * The form title.
     *
     * @var string
     */
    public $title = 'メールフォーム';

    /**
     * Handle the form request.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request)
    {
        // 送信ボタン押した後の処理
        //admin_success('Processed successfully.');
        admin_success($request->text); // 入力内容取得
        return back();
    }

    /**
     * Build a form here.
     */
    public function form()
    {
		$this->textarea("text", __('Send mail text'));
    }

    /**
     * The data of the form.
     *
     * @return array $data
     */
    public function data()
    {
        return [
        ];
    }
}
