<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * @todo このファイルはLaravel-adminを使用していた時のもの．
 *       現在の管理画面は別のライブラリを使用しているので，状況を見て削除する．
 */
class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $content;

    /**
     * 新しいメッセージのインスタンスを作成する．
     *
     * @link https://readouble.com/laravel/9.x/ja/mail.html
     *
     * @return void
     */
    public function __construct(string $content)
    {
        $this->content = $content;
    }

    /**
     * メッセージを構築する．
     *
     * @link https://readouble.com/laravel/9.x/ja/mail.html
     * @see resources/views/emails/contact.blade.php
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('******@example.com') // 送信元
            ->subject('HxSコンピュータ部・掲示板サイト') // メールタイトル
            ->text('emails.contact') // どのテンプレートを呼び出すか
            ->with(['content' => $this->content]); // withオプションでセットしたデータをテンプレートへ受け渡す
    }
}
