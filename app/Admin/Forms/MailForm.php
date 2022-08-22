<?php

namespace App\Admin\Forms;

use App\Mail\ContactMail;
use Encore\Admin\Widgets\Form;
use Illuminate\Support\Facades\Mail;
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
        $emails = [];
        for ($i = 0; $i <= $request->get('max'); $i++) {
            array_push($emails, $request->get('email' . $i));
        }
        Mail::to($emails)->send(new ContactMail($request->mail_message));

        admin_success('送信完了');
        return back();
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $max = 0;

        foreach ($this->data as $key => $email) {
            $this->hidden('email' . $key)->default($email);
            $max = $key;
        }
        $this->hidden('max')->default($max);
        $this->textarea("mail_message", __('Send mail text'));
    }

    /**
     * The data of the form.
     *
     * @return array $data
     */
    public function data()
    {
        return $this->data;
    }
}
