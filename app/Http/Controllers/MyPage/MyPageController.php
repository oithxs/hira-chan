<?php

namespace App\Http\Controllers\MyPage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MyPageController extends Controller
{
    /**
     * [GET] マイページを表示する．
     *
     * @link https://readouble.com/laravel/9.x/ja/views.html
     * @see resources/views/mypage/MyPage.blade.php
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $response['username'] = $request->user()->name;
        return view('mypage.MyPage', $response);
    }
}
