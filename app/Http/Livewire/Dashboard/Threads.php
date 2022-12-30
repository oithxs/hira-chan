<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Hub;
use App\Models\ThreadPrimaryCategory;
use Livewire\Component;
use Illuminate\Http\Request;

class Threads extends Component
{
    /**
     * スレッド一覧
     *
     * @var \Illuminate\Support\Collection
     */
    public $threads;

    /**
     * 大枠カテゴリ
     *
     * @var \Illuminate\Support\Collection
     */
    public $thread_primary_categorys;

    /**
     * ダッシュボードで表示するスレッドをカテゴリで絞り込む時の対象カテゴリ
     *
     * @var string
     */
    public $narrowing_down_category;

    /**
     * ダッシュボードで表示するスレッドのページ（10個ごと）
     *
     * @var int
     */
    public $page;

    /**
     * このページで使用するデータを定義する
     *
     * ダッシュボードで表示するスレッドのソートやカテゴリごとの絞り込みなど
     *
     * @link https://laravel-livewire.com/docs/2.x/rendering-components
     * @link https://readouble.com/laravel/9.x/ja/queries.html
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function mount(Request $request)
    {
        $this->narrowing_down_category = $request->category;
        $this->page = $request->page;
        $this->thread_primary_categorys = ThreadPrimaryCategory::with('thread_secondary_categorys')->get();

        if ($this->narrowing_down_category == NULL) {
            if ($request->sort == 'new_create') {
                $this->threads = Hub::withCount('access_logs')
                    ->orderBy('created_at', 'desc')
                    ->get();
            } else if ($request->sort == 'access_count') {
                $this->threads = Hub::withCount('access_logs')
                    ->orderBy('access_logs_count', 'desc')
                    ->get();
            } else {
                $this->threads = Hub::withCount('access_logs')
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
        } else {
            if ($request->sort == 'new_create') {
                $this->threads = Hub::withCount('access_logs')
                    ->where('thread_secondary_category_id', '=', $this->narrowing_down_category)
                    ->orderBy('created_at', 'desc')
                    ->get();
            } else if ($request->sort == 'access_count') {
                $this->threads = Hub::withCount('access_logs')
                    ->where('thread_secondary_category_id', '=', $this->narrowing_down_category)
                    ->orderBy('access_logs_count', 'desc')
                    ->get();
            } else {
                $this->threads = Hub::withCount('access_logs')
                    ->where('thread_secondary_category_id', '=', $this->narrowing_down_category)
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
        }
    }

    /**
     * ダッシュボードのスレッドを表示する部分
     *
     * @link https://laravel-livewire.com/docs/2.x/rendering-components
     * @see resources/views/dashboard/threads.blade.php
     *
     * @return \Illuminate\Support\Facades\View
     */
    public function render(Request $request)
    {
        return view('dashboard.threads');
    }
}
