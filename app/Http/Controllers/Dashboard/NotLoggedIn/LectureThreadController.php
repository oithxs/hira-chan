<?php

namespace App\Http\Controllers\Dashboard\NotLoggedIn;

use App\Http\Controllers\Controller;
use App\Models\LectureThread;

class LectureThreadController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param string $user_id
     * @param string $thread_id
     * @param int $pre_max_message_id
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
