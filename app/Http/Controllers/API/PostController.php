<?php

namespace App\Http\Controllers\API;

use App\Events\Post\PostStoreEvent;
use App\Exceptions\ThreadNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Services\Tables\PostService;
use App\Services\ThreadImageService;
use Illuminate\Http\Request;
use TypeError;

class PostController extends Controller
{
    private PostService $postService;

    private ThreadImageService $threadImageService;

    public function __construct(PostService $postService, ThreadImageService $threadImageService)
    {
        $this->postService = $postService;
        $this->threadImageService = $threadImageService;
    }

    /**
     * 該当スレッドの書き込み一覧を取得する
     *
     * @param Request $request アクセス時のパラメータなど
     * @return PostResource 成形済みの書き込み一覧
     */
    public function index(Request $request): PostResource
    {
        try {
            return new PostResource($this->postService->getPostWithUserImageAndLikes(
                $request->threadId,
                $request->user()->id ?? '',
            ));
        } catch (TypeError | ThreadNotFoundException $e) {
            abort(404);
        }
    }

    /**
     * 該当スレッドへ書き込みを行う
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        // 書き込みの保存（メッセージ）
        $post = $this->postService->store(
            $request->threadId,
            $request->user()->id,
            $request->message,
            $request->reply
        );

        // 書き込みでアップロードされた画像の保存（画像があれば）
        !$request->hasFile('img')
            ?: $this->threadImageService->store($request->file('img'), $post, $request->user()->id);

        // 同じスレッドを閲覧しているユーザにブロードキャスト
        broadcast(new PostStoreEvent($request->threadId, $post));
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
