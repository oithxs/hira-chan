<?php

namespace App\Http\Controllers\API;

use App\Events\ThreadBrowsing\AddLikeOnPost;
use App\Events\ThreadBrowsing\DeleteLikeOnPost;
use App\Http\Controllers\Controller;
use App\Services\Tables\LikeService;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    private LikeService $likeService;

    public function __construct(LikeService $likeService)
    {
        $this->likeService = $likeService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * スレッドへの書き込みに対するいいねを保存する
     *
     * @todo https://github.com/oithxs/hira-chan/issues/227
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function store(Request $request): void
    {
        // 書き込みへのいいねを保存
        $post = $this->likeService->addLikeOnPost(
            $request->threadId,
            $request->messageId,
            $request->user()->id
        );

        // 返却する書き込みのいいね数も増加させる
        $post['likes_count'] += 1;

        // 同じスレッドを閲覧しているユーザに，いいねがされたことをブロードキャスト
        broadcast(new AddLikeOnPost($request->threadId, $post));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * スレッドの書き込みに対するいいねを削除する
     *
     * @todo https://github.com/oithxs/hira-chan/issues/227
     *
     * @param  Request $request
     * @return void
     */
    public function destroy(Request $request)
    {
        // 書き込みのいいねを取り消し
        $post = $this->likeService->deleteLikeOnPost(
            $request->threadId,
            $request->messageId,
            $request->user()->id
        );

        // 返却する書き込みのいいね数を減少させる
        $post['likes_count'] -= 1;

        // 同じスレッドを閲覧しているユーザに，いいねがされたことをブロードキャスト
        broadcast(new DeleteLikeOnPost($request->threadId, $post));
    }
}
