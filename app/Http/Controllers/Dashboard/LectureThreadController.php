<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Dashboard\NotLoggedIn\LectureThreadController as Controller;
use App\Models\LectureThread;

class LectureThreadController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param string $thread_id
     * @param string $user_id
     * @param string $message
     *
     * @return int
     */
    public function store(string $thread_id, string $user_id, string $message)
    {
        $message_id = LectureThread::where('hub_id', '=', $thread_id)->max('message_id') + 1 ?? 0;
        LectureThread::create([
            'hub_id' => $thread_id,
            'user_id' => $user_id,
            'message_id' => $message_id,
            'message' => $message
        ]);
        return $message_id;
    }
}
