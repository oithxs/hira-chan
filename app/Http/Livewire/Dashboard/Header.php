<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\ThreadCategory;
use Illuminate\Http\Request;
use Livewire\Component;

class Header extends Component
{
    /**
     * カテゴリテーブルの全てのデータ
     *
     * @var \Illuminate\Support\Collection
     */
    public $categorys;

    /**
     * カテゴリテーブルの内大枠カテゴリのみ
     *
     * @var \Illuminate\Support\Collection
     */
    public $category_types;

    /**
     * このページで使用するデータ定義
     *
     * @link https://laravel-livewire.com/docs/2.x/rendering-components
     * @link https://readouble.com/laravel/9.x/ja/queries.html
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function mount(Request $request)
    {
        $this->categorys = ThreadCategory::get();
        $this->category_types = ThreadCategory::select('category_type')
            ->distinct('category_type')
            ->get();
    }

    /**
     * ダッシュボードのヘッダー部分表示
     *
     * @link https://laravel-livewire.com/docs/2.x/rendering-components
     * @see resources/views/dashboard/header.blade.php
     *
     * @return \Illuminate\Support\Facades\View
     */
    public function render()
    {
        return view('dashboard.header');
    }
}
