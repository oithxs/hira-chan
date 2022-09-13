<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\JobHuntingThread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobHuntingThreadController extends Controller
{
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
        $message_id = JobHuntingThread::where('hub_id', '=', $thread_id)->max('message_id') + 1 ?? 0;
        JobHuntingThread::create([
            'hub_id' => $thread_id,
            'user_id' => $user_id,
            'message_id' => $message_id,
            'message' => $message
        ]);
        return $message_id;
    }

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
        return JobHuntingThread::with('user')
            ->select(
                'job_hunting_threads.*',
                DB::raw('COUNT(likes1.user_email) AS count_user'),
                DB::raw('COALESCE((likes2.user_email), 0) AS user_like'),
                'thread_image_paths.img_path'
            )
            ->leftjoin('likes AS likes1', function ($join) use ($thread_id) {
                $join
                    ->where('likes1.thread_id', '=', $thread_id)
                    ->whereColumn('likes1.message_id', '=', 'job_hunting_threads.message_id');
            })
            ->leftjoin('likes AS likes2', function ($join) use ($thread_id, $user_email) {
                $join
                    ->where('likes2.thread_id', '=', $thread_id)
                    ->where('likes2.user_email', '=', $user_email)
                    ->whereColumn('likes2.message_id', '=', 'job_hunting_threads.message_id');
            })
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JobHuntingThread  $jobHuntingThreads
     * @return \Illuminate\Http\Response
     */
    public function edit(JobHuntingThread $jobHuntingThreads)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JobHuntingThread  $jobHuntingThreads
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JobHuntingThread $jobHuntingThreads)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JobHuntingThread  $jobHuntingThreads
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobHuntingThread $jobHuntingThreads)
    {
        //
    }
}
