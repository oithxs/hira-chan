<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Dashboard\NotLoggedIn\ThreadsController as Controller;
use App\Models\Hub;
use Illuminate\Http\Request;

class ThreadsController extends Controller
{
    /**
     * [POST] スレッドへの書き込みを検証し，保存する
     *
     * 特殊文字変換のエスケープなどを行う．
     * このメソッドから各カテゴリ用のクラスを呼び出し，DBにメッセージなどを書き込む．
     * ファイルがアップロードされた場合，ThreadImagePathController を呼び出す．
     *
     * @link https://readouble.com/laravel/9.x/ja/queries.html
     * @see \App\Http\Controllers\Dashboard\ClubThreadController::store() [Call]
     * @see \App\Http\Controllers\Dashboard\CollegeYearThreadController::store() [Call]
     * @see \App\Http\Controllers\Dashboard\DepartmentThreadController::store() [Call]
     * @see \App\Http\Controllers\Dashboard\JobHuntingThreadController::store() [Call]
     * @see \App\Http\Controllers\Dashboard\LectureThreadController::store() [Call]
     * @see \App\Http\Controllers\Dashboard\ThreadImagePathController::store() [Call]
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function store(Request $request)
    {
        if (!Hub::where('id', '=', $request->thread_id)->where('is_enabled', '=', 1)->first()) return;
        $special_character_set = array(
            "&" => "&amp;",
            "<" => "&lt;",
            ">" => "&gt;",
            " " => "&ensp;",
            "　" => "&emsp;",
            "\n" => "<br>",
            "\t" => "&ensp;&ensp;"
        );

        $message = $request->message;
        foreach ($special_character_set as $key => $value) {
            $message = str_replace($key, $value, $message);
        }

        if ($request->reply != null) {
            $reply = '<a class="bg-info" href="#thread_message_id_' . str_replace('>>> ', '', $request->reply) . '">' . $request->reply . '</a>';
            $message = $reply . '<br>' . $message;
        }

        $message_id = 0;
        $thread = Hub::with('thread_category')
            ->where('id', '=', $request->thread_id)
            ->where('is_enabled', '=', 1)
            ->first();

        switch ($thread->thread_category->category_type) {
            case '部活':
                $message_id = (new ClubThreadController)->store($request->thread_id, $request->user()->id, $message);
                break;
            case '学年':
                $message_id = (new CollegeYearThreadController)->store($request->thread_id, $request->user()->id, $message);
                break;
            case '学科':
                $message_id = (new DepartmentThreadController)->store($request->thread_id, $request->user()->id, $message);
                break;
            case '就職':
                $message_id = (new JobHuntingThreadController)->store($request->thread_id, $request->user()->id, $message);
                break;
            case '授業':
                $message_id = (new LectureThreadController)->store($request->thread_id, $request->user()->id, $message);
                break;
            default:
                break;
        }

        (new ThreadImagePathController)->store($request->file('img'), $request->user()->id, $request->thread_id, $message_id, $thread->thread_category->category_type);
    }
}
