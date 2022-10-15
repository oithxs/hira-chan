<?php

namespace App\Http\Controllers\Dashboard\NotLoggedIn;

use App\Http\Controllers\Controller;
use App\Models\Hub;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThreadsController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Support\Collection | void
     */
    public function show(Request $request)
    {
        if (Auth::check()) {
            $user_id = $request->user()->id;
        } else {
            $user_id = '';
        }

        $thread = Hub::with('thread_category')
            ->where('id', '=', $request->thread_id)
            ->where('is_enabled', '=', 1)
            ->first();

        switch ($thread->thread_category->category_type) {
            case '部活':
                return (new ClubThreadController)->show($user_id, $request->thread_id, $request->max_message_id);
            case '学年':
                return (new CollegeYearThreadController)->show($user_id, $request->thread_id, $request->max_message_id);
            case '学科':
                return (new DepartmentThreadController)->show($user_id, $request->thread_id, $request->max_message_id);
            case '授業':
                return (new LectureThreadController)->show($user_id, $request->thread_id, $request->max_message_id);
            case '就職':
                return (new JobHuntingThreadController)->show($user_id, $request->thread_id, $request->max_message_id);
            default:
                return null;
        }
    }
}
