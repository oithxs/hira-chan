<?php

namespace App\Http\Controllers\QandA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QandAController extends Controller
{
    /**
     * [GET] よくある質問ページを表示する．
     *
     * @link https://readouble.com/laravel/9.x/ja/views.html
     * @see resources/views/Q_and_A/show.blade.php
     * @todo 削除予定．代わりに掲示板の説明ページを作成する．
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Support\Facades\View
     */
    public function Q_and_A(Request $request)
    {
        return view('Q_and_A.show');
    }
}
