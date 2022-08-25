<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\CollegeYearThread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CollegeYearThreadController extends Controller
{
    /** @var string */
    private $user_email;

    /** @var string */
    private $thread_id;

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
     * @param string $user_name
     * @param string $user_email
     * @param string $message
     *
     * @return int
     */
    public function store(string $thread_id, string $user_name, string $user_email, string $message)
    {
        $message_id = CollegeYearThread::where('thread_id', '=', $thread_id)->max('message_id') + 1 ?? 0;
        CollegeYearThread::create([
            'thread_id' => $thread_id,
            'message_id' => $message_id,
            'user_name' => $user_name,
            'user_email' => $user_email,
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
        $this->user_email = $user_email;
        $this->thread_id = $thread_id;

        return CollegeYearThread::select(
            'college_year_threads.*',
            DB::raw('COUNT(likes1.user_email) AS count_user'),
            DB::raw('COALESCE((likes2.user_email), 0) AS user_like'),
            'thread_image_paths.img_path'
        )
            ->leftjoin('likes AS likes1', function ($join) {
                $join
                    ->where('likes1.thread_id', '=', $this->thread_id)
                    ->whereColumn('likes1.message_id', '=', 'college_year_threads.message_id');
            })
            ->leftjoin('likes AS likes2', function ($join) {
                $join
                    ->where('likes2.thread_id', '=', $this->thread_id)
                    ->where('likes2.user_email', '=', $this->user_email)
                    ->whereColumn('likes2.message_id', '=', 'college_year_threads.message_id');
            })
            ->leftjoin('thread_image_paths', function ($join) {
                $join
                    ->whereColumn('thread_image_paths.thread_id', '=', 'college_year_threads.thread_id')
                    ->whereColumn('thread_image_paths.message_id', '=', 'college_year_threads.message_id');
            })
            ->where('college_year_threads.thread_id', '=', $this->thread_id)
            ->where('college_year_threads.message_id', '>', $pre_max_message_id)
            ->groupBy('college_year_threads.message_id')
            ->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CollegeYearThread  $collegeYearThreads
     * @return \Illuminate\Http\Response
     */
    public function edit(CollegeYearThread $collegeYearThreads)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CollegeYearThread  $collegeYearThreads
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CollegeYearThread $collegeYearThreads)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CollegeYearThread  $collegeYearThreads
     * @return \Illuminate\Http\Response
     */
    public function destroy(CollegeYearThread $collegeYearThreads)
    {
        //
    }
}
