<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Get;

class DashboardController extends Controller
{
    public function top(Request $request)
    {
        $get = new Get;
        $access_ranking = $get->access_ranking();
        $threads = $get->showTables();

        $response['type'] = 'top';
        $response['access_ranking'] = $access_ranking;
        $response['tables'] = $threads;
        $response['thread_id'] = $request->thread_id;

        return view('dashboard', $response);
    }

    public function thread(Request $request)
    {
        $get = new Get;
        $access_ranking = $get->access_ranking();
        $messages = $get->allRow(
            $request->thread_id,
            $request->user()->id
        );


        if ($messages == 0) {
            $response['result'] = 0;
        } else {
            $response['result'] = 1;
        }

        $response['type'] = 'thread';
        $response['thread_name'] = $request->thread_name;
        $response['thread_id'] = $request->thread_id;
        $response['access_ranking'] = $access_ranking;

        return view('dashboard', $response);
    }
}
