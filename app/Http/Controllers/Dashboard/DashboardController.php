<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * [GET] ダッシュボードでスレッド一覧を表示する場合．
     *
     * @link https://readouble.com/laravel/9.x/ja/views.html
     * @see resources/views/dashboard/show.blade.php
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
     * [GET] ダッシュボードでスレッドにアクセスしている場合．
     *
     * @link https://readouble.com/laravel/9.x/ja/views.html
     * @see resources/views/dashboard/show.blade.php
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
