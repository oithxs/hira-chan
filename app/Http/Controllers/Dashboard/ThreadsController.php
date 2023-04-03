<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Posts\StoreRequest;
use App\Services\PostService;
use App\Services\ThreadImageService;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

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
     * [POST] スレッドの書き込みを取得する．

     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Support\Collection | void
     */
    public function show(Request $request)
    {
        return $this->postService->show(
            $request->thread_id,
            $request->user()->id ?? '',
            $request->max_message_id
        );
    }

    /**
     * [POST] スレッドへの書き込みを検証し，保存する
     *
     * 特殊文字変換のエスケープなどを行う．
     * このメソッドから各カテゴリ用のクラスを呼び出し，DBにメッセージなどを書き込む．
     * ファイルがアップロードされた場合，画像を保存する．
     *
     * @param  StoreRequest  $request
     * @return void
     */
    public function store(StoreRequest $request)
    {
        $message = is_null($request->message) && $request->img instanceof UploadedFile
            ? ''
            : $request->message;

        // 書き込みの保存（メッセージ）
        $post = $this->postService->store($request->thread_id, $request->user()->id, $message, $request->reply, $request->file('img'));

        // 書き込みでアップロードされた画像の保存（画像があれば）
        !$request->hasFile('img') ?: $this->threadImageService->store($request->file('img'), $post, $request->user()->id);
    }
}
