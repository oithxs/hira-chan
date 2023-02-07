<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ClubThread;
use App\Models\CollegeYearThread;
use App\Models\DepartmentThread;
use App\Models\Hub;
use App\Models\JobHuntingThread;
use App\Models\LectureThread;
use App\Models\Like;
use App\Services\LikeService;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    private LikeService $likeService;

    public function __construct()
    {
        $this->likeService = new LikeService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * [POST] スレッドへの書き込みに対するいいねを保存する．
     *
     * @todo https://github.com/oithxs/hira-chan/issues/227
     *
     * @param  \Illuminate\Http\Request  $request
     * @return integer いいねをした書き込みがされているいいね数
     */
    public function store(Request $request): int
    {
        $this->likeService->store(
            $request->thread_id,
            $request->message_id,
            $request->user()->id
        );
        return $this->likeService->countLike();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Like  $likes
     * @return \Illuminate\Http\Response
     */
    public function show(Like $likes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Like  $likes
     * @return \Illuminate\Http\Response
     */
    public function edit(Like $likes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Like  $likes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Like $likes)
    {
        //
    }

    /**
     * [POST] スレッドの書き込みに対するいいねを削除する
     *
     * @todo https://github.com/oithxs/hira-chan/issues/227
     *
     * @param  \Illuminate\Htt\Request $request
     * @return int
     */
    public function destroy(Request $request)
    {
        $this->likeService->destroy(
            $request->thread_id,
            $request->message_id,
            $request->user()->id
        );
        return $this->likeService->countLike();
    }
}
