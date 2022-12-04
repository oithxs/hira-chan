<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Hub;
use App\Models\ThreadCategory;
use Illuminate\Http\Request;

class HubController extends Controller
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
     * [POST] スレッドを作成する．
     *
     * @link https://readouble.com/laravel/9.x/ja/queries.html
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function store(Request $request)
    {
        $thread_category_id = ThreadCategory::where('category_name', '=', $request->thread_category)->first()->id;

        Hub::create([
            'thread_category_id' => $thread_category_id,
            'user_id' => $request->user()->id,
            'name' => $request->thread_name
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Hub  $hub
     * @return \Illuminate\Http\Response
     */
    public function show(Hub $hub)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Hub  $hub
     * @return \Illuminate\Http\Response
     */
    public function edit(Hub $hub)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Hub  $hub
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hub $hub)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Hub  $hub
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hub $hub)
    {
        //
    }
}
