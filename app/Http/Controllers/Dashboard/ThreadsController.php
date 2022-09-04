<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\NotLoggedIn\ThreadsController as NotLoggedInThreadsController;
use App\Models\Hub;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * @return void
     */
    public function store(Request $request)
    {
        if (!Hub::where('thread_id', '=', $request->thread_id)->where('is_enabled', '=', 1)->first()) return;
        $special_character_set = array(
            "&" => "&amp;",
            "<" => "&lt;",
            ">" => "&gt;",
            " " => "&ensp;",
            "　" => "&emsp;",
            "\n" => "<br>",
            "\t" => "&ensp;&ensp;"
        );

        $message = $request->message;
        foreach ($special_character_set as $key => $value) {
            $message = str_replace($key, $value, $message);
        }

        if ($request->reply != null) {
            $reply = '<a class="bg-info" href="#thread_message_id_' . str_replace('>>> ', '', $request->reply) . '">' . $request->reply . '</a>';
            $message = $reply . '<br>' . $message;
        }

        $message_id = 0;
        $thread = Hub::where('thread_id', '=', $request->thread_id)->first();
        switch ($thread->thread_category_type) {
            case '学科':
                $message_id = (new DepartmentThreadController)->store($request->thread_id, $request->user()->name, $request->user()->email, $message);
                break;
            case '学年':
                $message_id = (new CollegeYearThreadController)->store($request->thread_id, $request->user()->name, $request->user()->email, $message);
                break;
            case '部活':
                $message_id = (new ClubThreadController)->store($request->thread_id, $request->user()->name, $request->user()->email, $message);
                break;
            case '授業':
                $message_id = (new LectureThreadController)->store($request->thread_id, $request->user()->name, $request->user()->email, $message);
                break;
            case '就職':
                $message_id = (new JobHuntingThreadController)->store($request->thread_id, $request->user()->name, $request->user()->email, $message);
            default:
                break;
        }

        (new ThreadImagePathController)->store($request, $message_id);
    }

    /**
     * Display the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Support\Collection | void
     */
    public function show(Request $request)
    {
        if (!Auth::check()) {
            return (new NotLoggedInThreadsController)->show($request->thread_id, $request->max_message_id);
        }

        $thread = Hub::where('thread_id', '=', $request->thread_id)
            ->where('is_enabled', '=', 1)
            ->first();
        switch ($thread->thread_category_type) {
            case '学科':
                return (new DepartmentThreadController)->show($request->user()->email, $request->thread_id, $request->max_message_id);
            case '学年':
                return (new CollegeYearThreadController)->show($request->user()->email, $request->thread_id, $request->max_message_id);
            case '部活':
                return (new ClubThreadController)->show($request->user()->email, $request->thread_id, $request->max_message_id);
            case '授業':
                return (new LectureThreadController)->show($request->user()->email, $request->thread_id, $request->max_message_id);
            case '就職':
                return (new JobHuntingThreadController)->show($request->user()->email, $request->thread_id, $request->max_message_id);
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
