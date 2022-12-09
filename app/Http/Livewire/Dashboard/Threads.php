<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Hub;
use App\Models\ThreadCategory;
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
     * カテゴリ一覧
     *
     * @var \Illuminate\Support\Collection
     */
    public $categorys;

    /**
     * 大枠カテゴリ一覧
     *
     * @var \Illuminate\Support\Collection
     */
    public $category_types;

    /**
     * ダッシュボードで表示するスレッドをカテゴリで絞り込む時の対象カテゴリ
     *
     * @var \Illuminate\Support\Collection
     */
    public $category_name;

    /**
     * ダッシュボードで表示するスレッドのページ（10個ごと）
     *
     * @var \Illuminate\Support\Collection
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
        if ($request->category == NULL) {
            if ($request->sort == 'new_create') {
                $this->threads = Hub::withCount('access_logs')
                    ->where('is_enabled', '=', 1)
                    ->orderBy('created_at', 'desc')
                    ->get();
            } else if ($request->sort == 'access_count') {
                $this->threads = Hub::withCount('access_logs')
                    ->where('is_enabled', '=', 1)
                    ->orderBy('access_logs_count', 'desc')
                    ->get();
            } else {
                $this->threads = Hub::withCount('access_logs')
                    ->where('is_enabled', '=', 1)
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
        } else {
            if ($request->sort == 'new_create') {
                $this->threads = Hub::withCount('access_logs')
                    ->where('thread_category_id', '=', $request->category)
                    ->where('is_enabled', '=', 1)
                    ->orderBy('created_at', 'desc')
                    ->get();
            } else if ($request->sort == 'access_count') {
                $this->threads = Hub::withCount('access_logs')
                    ->where('thread_category_id', '=', $request->category)
                    ->where('is_enabled', '=', 1)
                    ->orderBy('access_logs_count', 'desc')
                    ->get();
            } else {
                $this->threads = Hub::withCount('access_logs')
                    ->where('thread_category_id', '=', $request->category)
                    ->where('is_enabled', '=', 1)
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
        }

        $this->categorys = ThreadCategory::get();
        $this->category_types = ThreadCategory::select('category_type')
            ->distinct('category_type')
            ->get();
        $this->category_name = $request->category;
        $this->page = $request->page;
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
