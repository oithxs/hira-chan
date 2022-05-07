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

class VerifyEmailAddURL extends Notification
{
    /**
     * The callback that should be used to build the mail message.
     *
     * @var \Closure|null
     */
    public static $toMailCallback;

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);
        $accountDeleteUrl = $this->accountDeleteUrl($notifiable);

        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $verificationUrl, $accountDeleteUrl);
        }

        return (new MailMessage)
            ->subject(Lang::get('メールアドレスを認証してください'))
            ->line(Lang::get('以下のボタンをクリックしてメールアドレスを認証してください'))
            ->action(Lang::get('認証する'), $verificationUrl)
            ->line(Lang::get('もしこのメールに覚えがない場合はあなたのEmailアドレスがHxSコンピュータ部掲示板サービスのアカウント登録に使用されています．以下のURLにアクセスすると該当アカウントを削除する事ができます'))
            ->line(Lang::get('放置しても構いません．'))
            ->line(Lang::get($accountDeleteUrl));
    }

    /**
     * Get the verification URL for the given notifiable.
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

    protected function accountDeleteUrl($notifiable) {
        return URL::temporarySignedRoute(
            'account/delete',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1(
                    $notifiable->getKey() . 
                    $notifiable->getEmailForVerification() . 
                    $notifiable->getKey()
                ),
            ]
        );
    }

    /**
     * Set a callback that should be used when building the notification mail message.
     *
     * @param  \Closure  $callback
     * @return void
     */
    public static function toMailUsing($callback)
    {
        static::$toMailCallback = $callback;
    }
}