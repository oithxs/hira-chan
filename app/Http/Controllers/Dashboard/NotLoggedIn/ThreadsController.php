<?php

namespace App\Http\Controllers\Dashboard\NotLoggedIn;

use App\Http\Controllers\Controller;
use App\Models\Hub;
use Illuminate\Http\Request;

class ThreadsController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param string $thread_id
     * @param int $pre_max_message_id
     *
     * @return \Illuminate\Support\Collection | void
     */
    public function show(string $thread_id, int $pre_max_message_id)
    {
        $thread = Hub::where('thread_id', '=', $thread_id)
            ->where('is_enabled', '=', 1)
            ->first();
        switch ($thread->thread_category_type) {
            case '学科':
                return (new DepartmentThreadController)->show($thread_id, $pre_max_message_id);
            case '学年':
                return (new CollegeYearThreadController)->show($thread_id, $pre_max_message_id);
            case '部活':
                return (new ClubThreadController)->show($thread_id, $pre_max_message_id);
            case '授業':
                return (new LectureThreadController)->show($thread_id, $pre_max_message_id);
            case '就職':
                return (new JobHuntingThreadController)->show($thread_id, $pre_max_message_id);
            default:
                return null;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
