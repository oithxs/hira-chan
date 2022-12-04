<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\URL;

class VerifyEmailNotification extends Notification
{
    /**
     * メールメッセージを構築するために使用されるべきコールバック．
     *
     * @var \Closure|null
     */
    public static $toMailCallback;

    /**
     * 通知のチャンネルを取得する．
     *
     * @link https://readouble.com/laravel/9.x/ja/notifications.html
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * 通知のメール表現を構築する．
     *
     * @link https://readouble.com/laravel/9.x/ja/notifications.html
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $verificationUrl);
        }

        return (new MailMessage)
            ->subject(Lang::get('メールアドレスを認証してください'))
            ->line(Lang::get('以下のボタンをクリックしてメールアドレスを認証してください'))
            ->action(Lang::get('認証する'), $verificationUrl)
            ->line(Lang::get('（もしこのメールに覚えがない場合は放置して問題ございません）'));
    }

    /**
     * 指定された通知先の検証用URLを取得する．
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }

    /**
     * 通知メールメッセージの構築時に使用されるコールバックを設定する．
     *
     * @link https://readouble.com/laravel/9.x/ja/verification.html
     *
     * @param  \Closure  $callback
     * @return void
     */
    public static function toMailUsing($callback)
    {
        static::$toMailCallback = $callback;
    }
}
