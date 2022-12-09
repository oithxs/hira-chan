<?php

namespace App\Http\Controllers\Dashboard\NotLoggedIn;

use App\Http\Controllers\Controller;
use App\Models\LectureThread;

class LectureThreadController extends Controller
{
    /**
     * カテゴリ「授業」のスレッドを取得する．
     * 2回目以降に呼び出された場合，前回取得した書き込みから更新された書き込みのみ返却する．
     *
     * @link https://readouble.com/laravel/9.x/ja/queries.html
     * @see \App\Http\Controllers\Dashboard\NotLoggedIn\ThreadController::show()　[Called]
     *
     * @param string $user_id ユーザID
     * @param string $thread_id スレッド（Hub）ID
     * @param int $pre_max_message_id 前回取得したメッセージIDの最大値
     *
     * @return \Illuminate\Support\Collection
     */
    public function show(string $user_id, string $thread_id, int $pre_max_message_id)
    {
        return LectureThread::with([
            'user',
            'thread_image_path',
            'likes' => function ($query) use ($user_id) {
                $query->where('user_id', '=', $user_id);
            }
        ])
            ->withCount('likes')
            ->where('hub_id', '=', $thread_id)
            ->where('message_id', '>', $pre_max_message_id)
            ->groupBy('message_id')
            ->get();
    }
}
