<?php

namespace App\Http\Controllers\Dashboard\NotLoggedIn;

use App\Http\Controllers\Controller;
use App\Models\LectureThread;
use Illuminate\Support\Facades\DB;

class LectureThreadController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param string $user_email
     * @param string $thread_id
     * @param int $pre_max_message_id
     *
     * @return \Illuminate\Support\Collection
     */
    public function show(string $user_email, string $thread_id, int $pre_max_message_id)
    {
        return LectureThread::with('user')
            ->select(
                'lecture_threads.*',
                DB::raw('COUNT(likes1.user_email) AS count_user'),
                DB::raw('COALESCE((likes2.user_email), 0) AS user_like'),
                'thread_image_paths.img_path'
            )
            ->leftjoin('likes AS likes1', function ($join) use ($thread_id) {
                $join
                    ->where('likes1.thread_id', '=', $thread_id)
                    ->whereColumn('likes1.message_id', '=', 'lecture_threads.message_id');
            })
            ->leftjoin('likes AS likes2', function ($join) use ($thread_id, $user_email) {
                $join
                    ->where('likes2.thread_id', '=', $thread_id)
                    ->where('likes2.user_email', '=', $user_email)
                    ->whereColumn('likes2.message_id', '=', 'lecture_threads.message_id');
            })
            ->leftjoin('thread_image_paths', function ($join) {
                $join
                    ->whereColumn('thread_image_paths.thread_id', '=', 'lecture_threads.hub_id')
                    ->whereColumn('thread_image_paths.message_id', '=', 'lecture_threads.message_id');
            })
            ->where('lecture_threads.hub_id', '=', $thread_id)
            ->where('lecture_threads.message_id', '>', $pre_max_message_id)
            ->groupBy('lecture_threads.message_id')
            ->get();
    }
}
