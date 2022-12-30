<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Hub;
use Livewire\Component;
use Illuminate\Http\Request;

class SelectThreadPages extends Component
{
    /**
     * スレッド数
     *
     * @var int
     */
    public $max_thread;

    /**
     * ダッシュボードでスレッドを表示する際のソートタイプ
     *
     * @todo たしか，ソートが出来る様になっていなかったためソートが出来る様に修正する
     *
     * @var string
     */
    public $sort;

    /**
     * ダッシュボードで表示するスレッドをカテゴリで絞り込む時の対象カテゴリ
     *
     * @var string
     */
    public $narrowing_down_category;

    /**
     * このページで使用するデータの定義
     *
     * @link https://laravel-livewire.com/docs/2.x/rendering-components
     * @link https://readouble.com/laravel/9.x/ja/queries.html
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function mount(Request $request)
    {
        if ($request->category == NULL) {
            $this->max_thread = Hub::count();
        } else {
            $this->max_thread = Hub::where('thread_secondary_category_id', '=', $request->category)
                ->count();
        }

        $this->sort = $request->sort;
        $this->narrowing_down_category = $request->category;
    }

    /**
     * ダッシュボードの表示するスレッドを切り替える部分
     *
     * @link https://laravel-livewire.com/docs/2.x/rendering-components
     * @see resources/views/dashboard/select-thread-pages.blade.php
     *
     * @return \Illuminate\Support\Facades\View
     */
    public function render()
    {
        return view('dashboard.select-thread-pages');
    }
}
