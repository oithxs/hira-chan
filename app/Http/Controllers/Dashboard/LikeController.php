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
use Illuminate\Http\Request;

class LikeController extends Controller
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
     * [POST] スレッドへの書き込みに対するいいねを保存する．
     *
     * @link https://readouble.com/laravel/9.x/ja/queries.html
     * @todo https://github.com/oithxs/hira-chan/issues/227
     *
     * @param  \Illuminate\Http\Request  $request
     * @return int
     */
    public function store(Request $request)
    {
        $thread = Hub::with('thread_secondary_category')
            ->where('id', '=', $request->thread_id)
            ->first();

        switch ($thread->thread_secondary_category->thread_primary_category->name) {
            case '部活':
                $club_thread_id = ClubThread::where('hub_id', '=', $request->thread_id)
                    ->where('message_id', '=', $request->message_id)
                    ->first()
                    ->id;
                Like::create([
                    'club_thread_id' => $club_thread_id,
                    'user_id' => $request->user()->id
                ]);
                return Like::where('club_thread_id', '=', $club_thread_id)->count();

            case '学年':
                $college_year_thread_id = CollegeYearThread::where('hub_id', '=', $request->thread_id)
                    ->where('message_id', '=', $request->message_id)
                    ->first()
                    ->id;
                Like::create([
                    'college_year_thread_id' => $college_year_thread_id,
                    'user_id' => $request->user()->id
                ]);
                return Like::where('college_year_thread_id', '=', $college_year_thread_id)->count();

            case '学科':
                $department_thread_id = DepartmentThread::where('hub_id', '=', $request->thread_id)
                    ->where('message_id', '=', $request->message_id)
                    ->first()
                    ->id;
                Like::create([
                    'department_thread_id' => $department_thread_id,
                    'user_id' => $request->user()->id
                ]);
                return Like::where('department_thread_id', '=', $department_thread_id)->count();

            case '就職':
                $job_hunting_thread_id = JobHuntingThread::where('hub_id', '=', $request->thread_id)
                    ->where('message_id', '=', $request->message_id)
                    ->first()
                    ->id;
                Like::create([
                    'job_hunting_thread_id' => $job_hunting_thread_id,
                    'user_id' => $request->user()->id
                ]);
                return Like::where('job_hunting_thread_id', '=', $job_hunting_thread_id)->count();

            case '授業':
                $lecture_thread_id = LectureThread::where('hub_id', '=', $request->thread_id)
                    ->where('message_id', '=', $request->message_id)
                    ->first()
                    ->id;
                Like::create([
                    'lecture_thread_id' => $lecture_thread_id,
                    'user_id' => $request->user()->id
                ]);
                return Like::where('lecture_thread_id', '=', $lecture_thread_id)->count();

            default:
                return 0;
        }
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
     * @link https://readouble.com/laravel/9.x/ja/queries.html
     * @todo https://github.com/oithxs/hira-chan/issues/227
     *
     * @param  \Illuminate\Htt\Request $request
     * @return int
     */
    public function destroy(Request $request)
    {
        $thread = Hub::with('thread_secondary_category')
            ->where('id', '=', $request->thread_id)
            ->first();

        switch ($thread->thread_secondary_category->thread_primary_category->name) {
            case '部活':
                $club_thread_id = ClubThread::where('hub_id', '=', $request->thread_id)
                    ->where('message_id', '=', $request->message_id)
                    ->first()
                    ->id;
                Like::where('club_thread_id', '=', $club_thread_id)
                    ->where('user_id', '=', $request->user()->id)
                    ->delete();
                return Like::where('club_thread_id', '=', $club_thread_id)->count();

            case '学年':
                $college_year_thread_id = CollegeYearThread::where('hub_id', '=', $request->thread_id)
                    ->where('message_id', '=', $request->message_id)
                    ->first()
                    ->id;
                Like::where('college_year_thread_id', '=', $college_year_thread_id)
                    ->where('user_id', '=', $request->user()->id)
                    ->delete();
                return Like::where('college_year_thread_id', '=', $college_year_thread_id)->count();

            case '学科':
                $department_thread_id = DepartmentThread::where('hub_id', '=', $request->thread_id)
                    ->where('message_id', '=', $request->message_id)
                    ->first()
                    ->id;
                Like::where('department_thread_id', '=', $department_thread_id)
                    ->where('user_id', '=', $request->user()->id)
                    ->delete();
                return Like::where('department_thread_id', '=', $department_thread_id)->count();

            case '就職':
                $job_hunting_thread_id = JobHuntingThread::where('hub_id', '=', $request->thread_id)
                    ->where('message_id', '=', $request->message_id)
                    ->first()
                    ->id;
                Like::where('job_hunting_thread_id', '=', $job_hunting_thread_id)
                    ->where('user_id', '=', $request->user()->id)
                    ->delete();
                return Like::where('job_hunting_thread_id', '=', $job_hunting_thread_id)->count();

            case '授業':
                $lecture_thread_id = LectureThread::where('hub_id', '=', $request->thread_id)
                    ->where('message_id', '=', $request->message_id)
                    ->first()
                    ->id;
                Like::where('lecture_thread_id', '=', $lecture_thread_id)
                    ->where('user_id', '=', $request->user()->id)
                    ->delete();
                return Like::where('lecture_thread_id', '=', $lecture_thread_id)->count();

            default:
                return 0;
        }
    }
}
