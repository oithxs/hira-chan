<?php

namespace App\Http\Controllers\ThreadBrowsingHistory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ThreadBrowsingHistoryController extends Controller
{
    public function __invoke(Request $request)
    {
        return view('thread-browsing-history.show');
    }
}
