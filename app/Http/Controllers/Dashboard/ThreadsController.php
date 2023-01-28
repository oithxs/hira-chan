<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Dashboard\NotLoggedIn\ThreadsController as Controller;
use App\Services\PostService;
use App\Services\ThreadImageService;
use Illuminate\Http\Request;

class ThreadsController extends Controller
{
    private PostService $postService;

    private ThreadImageService $threadImageService;

    public function __construct()
    {
        $this->postService = new PostService();
        $this->threadImageService = new ThreadImageService();
    }

    /**
     * [POST] スレッドへの書き込みを検証し，保存する
     *
     * 特殊文字変換のエスケープなどを行う．
     * このメソッドから各カテゴリ用のクラスを呼び出し，DBにメッセージなどを書き込む．
     * ファイルがアップロードされた場合，画像を保存する．
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function store(Request $request)
    {
        // 書き込みの保存（メッセージ）
        $post = $this->postService->store($request->thread_id, $request->user()->id, $request->message, $request->reply, $request->file('img'));

        // 書き込みでアップロードされた画像の保存（画像があれば）
        !$request->hasFile('img') ?: $this->threadImageService->store($request->file('img'), $post, $request->user()->id);
    }
}
