<?php

namespace App\Http\Controllers\dashboard;

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
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Support\Collection | void
     */
    public function show(Request $request)
    {
        $thread = Hub::where('thread_id', '=', $request->table)->first();
        switch ($thread->thread_category_type) {
            case '学科':
                return (new DepartmentThreadsController)->show($request->user()->email, $request->table);
            case '学年':
                return (new CollegeYearThreadsController)->show($request->user()->email, $request->table);
            case '部活':
                return (new ClubThreadsController)->show($request->user()->email, $request->table);
            case '授業':
                return (new LectureThreadsController)->show($request->user()->email, $request->table);
            case '就職':
                return (new JobHuntingThreadsController)->show($request->user()->email, $request->table);
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
