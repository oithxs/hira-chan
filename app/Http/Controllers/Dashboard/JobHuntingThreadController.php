<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Dashboard\NotLoggedIn\JobHuntingThreadController as Controller;
use App\Models\JobHuntingThread;

class JobHuntingThreadController extends Controller
{
    /**
     * カテゴリ「就職」に属するスレッドへの書き込みを行う．
     * メッセージIDのみはここで生成している．
     * メッセージIDを返却し，次回の取得時に送信データ削減に利用している．
     *
     * @link https://readouble.com/laravel/9.x/ja/queries.html
     * @see \App\Http\Controllers\Dashboard\ThreadsController::store() [Called]
     * @todo 同時にスレッドに書き込んだ際の動作を確認し，$message_id の処遇を決定する．
     *
     * @param string $thread_id スレッド（Hub）ID
     * @param string $user_id ユーザID
     * @param string $message 書き込み内容
     *
     * @return int
     */
    public function store(string $thread_id, string $user_id, string $message)
    {
        $message_id = JobHuntingThread::where('hub_id', '=', $thread_id)->max('message_id') + 1 ?? 0;
        JobHuntingThread::create([
            'hub_id' => $thread_id,
            'user_id' => $user_id,
            'message_id' => $message_id,
            'message' => $message
        ]);
        return $message_id;
    }
}
