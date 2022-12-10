<?php

namespace App\Http\Controllers\Dashboard\NotLoggedIn;

use App\Http\Controllers\Controller;
use App\Models\Hub;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThreadsController extends Controller
{
    /**
     * [POST] スレッドの書き込みを取得する．
     *
     * このメソッドから各カテゴリ用のクラスを呼び出し，書き込みを取得する．
     *
     * @link https://readouble.com/laravel/9.x/ja/authentication.html
     * @link https://readouble.com/laravel/9.x/ja/queries.html
     * @see \App\Http\Controllers\Dashboard\NotLoggedIn\ClubThreadController::show() [Call]
     * @see \App\Http\Controllers\Dashboard\NotLoggedIn\CollegeYearThreadController::show() [Call]
     * @see \App\Http\Controllers\Dashboard\NotLoggedIn\DepartmentThreadController::show() [Call]
     * @see \App\Http\Controllers\Dashboard\NotLoggedIn\JobHuntingThreadController::show() [Call]
     * @see \App\Http\Controllers\Dashboard\NotLoggedIn\LectureThreadController::show() [Call]
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Support\Collection | void
     */
    public function show(Request $request)
    {
        if (Auth::check()) {
            $user_id = $request->user()->id;
        } else {
            $user_id = '';
        }

        $thread = Hub::with('thread_category')
            ->where('id', '=', $request->thread_id)
            ->first();

        switch ($thread->thread_category->category_type) {
            case '部活':
                return (new ClubThreadController)->show($user_id, $request->thread_id, $request->max_message_id);
            case '学年':
                return (new CollegeYearThreadController)->show($user_id, $request->thread_id, $request->max_message_id);
            case '学科':
                return (new DepartmentThreadController)->show($user_id, $request->thread_id, $request->max_message_id);
            case '授業':
                return (new LectureThreadController)->show($user_id, $request->thread_id, $request->max_message_id);
            case '就職':
                return (new JobHuntingThreadController)->show($user_id, $request->thread_id, $request->max_message_id);
            default:
                return null;
        }
    }
}
