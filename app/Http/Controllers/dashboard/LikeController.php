<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return int
     */
    public function store(Request $request)
    {
        Like::insertOrIgnore([
            'thread_id' => $request->thread_id,
            'message_id' => $request->message_id,
            'user_email' => $request->user()->email,
            'created_at' => now(),
        ]);

        return Like::where('thread_id', '=', $request->thread_id)
            ->where('message_id', '=', $request->message_id)
            ->count();
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
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Htt\Request $request
     * @return int
     */
    public function destroy(Request $request)
    {
        Like::where('thread_id', '=', $request->thread_id)
            ->where('message_id', '=', $request->message_id)
            ->where('user_email', '=', $request->user()->email)
            ->delete();

        return Like::where('thread_id', '=', $request->thread_id)
            ->where('message_id', '=', $request->message_id)
            ->count();
    }
}
