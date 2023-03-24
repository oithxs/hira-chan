<?php

namespace App\Http\Controllers\API;

use App\Exceptions\ThreadNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Services\Tables\PostService;
use Illuminate\Http\Request;
use TypeError;

class PostController extends Controller
{
    private PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
