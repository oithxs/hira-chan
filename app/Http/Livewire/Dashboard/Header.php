<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\ThreadPrimaryCategory;
use Illuminate\Http\Request;
use Livewire\Component;

class Header extends Component
{
    /**
     * 大枠カテゴリ
     *
     * @var \Illuminate\Support\Collection
     */
    public $thread_primary_categorys;

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
        $this->thread_primary_categorys = ThreadPrimaryCategory::with('thread_secondary_categorys')->get();
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
