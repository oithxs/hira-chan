<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $content)
    {
        $this->content = $content;
    }

    /**
     * Build the message.
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