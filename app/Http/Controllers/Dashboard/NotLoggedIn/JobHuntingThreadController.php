<?php

namespace App\Http\Controllers\Dashboard\NotLoggedIn;

use App\Http\Controllers\Controller;
use App\Models\JobHuntingThread;

class JobHuntingThreadController extends Controller
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
        return JobHuntingThread::with([
            'user',
            'likes' => function ($query) use ($user_id) {
                $query->where('user_id', '=', $user_id);
            }
        ])
            ->withCount('likes')
            ->leftjoin('thread_image_paths', function ($join) {
                $join
                    ->whereColumn('thread_image_paths.thread_id', '=', 'job_hunting_threads.hub_id')
                    ->whereColumn('thread_image_paths.message_id', '=', 'job_hunting_threads.message_id');
            })
            ->where('job_hunting_threads.hub_id', '=', $thread_id)
            ->where('job_hunting_threads.message_id', '>', $pre_max_message_id)
            ->groupBy('job_hunting_threads.message_id')
            ->get();
    }
}
