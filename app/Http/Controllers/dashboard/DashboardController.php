<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function threads(Request $request)
    {
        return view('dashboard.show', [
            'main_type' => 'threads',
            'category' => $request->category,
            'page' => $request->page
        ]);
    }

    public function messages(Request $request)
    {
        return view('dashboard.show', [
            'main_type' => 'messages'
        ]);
    }
}
