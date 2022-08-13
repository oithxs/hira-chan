<?php

namespace App\Http\Controllers\Q_and_A;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Q_and_AController extends Controller
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
