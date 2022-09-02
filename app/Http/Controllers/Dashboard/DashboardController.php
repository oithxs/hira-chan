<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * For dashboard thread mode
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Support\Facades\View
     */
    public function threads(Request $request)
    {
        return view('dashboard.show', [
            'main_type' => 'threads',
            'category' => $request->category,
            'page' => $request->page
        ]);
    }

    /**
     * For dashboard messages mode
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Support\Facades\View
     */
    public function messages(Request $request)
    {
        return view('dashboard.show', [
            'main_type' => 'messages'
        ]);
    }
}
