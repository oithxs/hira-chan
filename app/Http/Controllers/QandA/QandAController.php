<?php

namespace App\Http\Controllers\QandA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QandAController extends Controller
{
    /**
     * Show Q&A page
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Support\Facades\View
     */
    public function Q_and_A(Request $request)
    {
        return view('Q_and_A.show');
    }
}
