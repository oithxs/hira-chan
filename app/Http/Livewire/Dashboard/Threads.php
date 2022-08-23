<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\ThreadCategorys;
use App\Models\Hub;

class Threads extends Component
{
    /** @var \Illuminate\Support\Collection */
    public $tables;

    /** @var \Illuminate\Support\Collection */
    public $categorys;

    /** @var \Illuminate\Support\Collection */
    public $category_types;

    /** @var \Illuminate\Support\Collection */
    public $category_name;

    /** @var \Illuminate\Support\Collection */
    public $page;

    /**
     * Storing data used on this page
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function mount(Request $request)
    {
        $category = $request->category;
        $sort = $request->sort;

        if ($category == NULL) {
            if ($sort == 'new_create') {
                $this->tables = Hub::selectRaw('hub.*, COALESCE(COUNT(access_logs.access_log), 0) AS Access')
                    ->leftJoin('access_logs', function ($join) {
                        $join->on('hub.thread_id', '=', 'access_logs.thread_id');
                    })
                    ->where('hub.is_enabled', '=', 1)
                    ->groupBy('hub.thread_id')
                    ->orderByRaw('hub.created_at DESC')
                    ->get();
            } else if ($sort == 'access_count') {
                $this->tables = Hub::selectRaw('hub.*, COALESCE(COUNT(access_logs.access_log), 0) AS Access')
                    ->leftJoin('access_logs', function ($join) {
                        $join->on('hub.thread_id', '=', 'access_logs.thread_id');
                    })
                    ->where('hub.is_enabled', '=', 1)
                    ->groupBy('hub.thread_id')
                    ->orderByRaw('COUNT(access_logs.access_log) DESC')
                    ->get();
            } else {
                $this->tables = Hub::selectRaw('hub.*, COALESCE(COUNT(access_logs.access_log), 0) AS Access')
                    ->leftJoin('access_logs', function ($join) {
                        $join->on('hub.thread_id', '=', 'access_logs.thread_id');
                    })
                    ->where('hub.is_enabled', '=', 1)
                    ->groupBy('hub.thread_id')
                    ->get();
            }
        } else {
            if ($sort == 'new_create') {
                $this->tables = Hub::selectRaw('hub.*, COALESCE(COUNT(access_logs.access_log), 0) AS Access')
                    ->leftJoin('access_logs', function ($join) {
                        $join->on('hub.thread_id', '=', 'access_logs.thread_id');
                    })
                    ->where('hub.thread_category', '=', $category)
                    ->where('hub.is_enabled', '=', 1)
                    ->groupBy('hub.thread_id')
                    ->orderByRaw('hub.created_at DESC')
                    ->get();
            } else if ($sort == 'access_count') {
                $this->tables = Hub::selectRaw('hub.*, COALESCE(COUNT(access_logs.access_log), 0) AS Access')
                    ->leftJoin('access_logs', function ($join) {
                        $join->on('hub.thread_id', '=', 'access_logs.thread_id');
                    })
                    ->where('hub.thread_category', '=', $category)
                    ->where('hub.is_enabled', '=', 1)
                    ->groupBy('hub.thread_id')
                    ->orderByRaw('COUNT(access_logs.access_log) DESC')
                    ->get();
            } else {
                $this->tables = Hub::selectRaw('hub.*, COALESCE(COUNT(access_logs.access_log), 0) AS Access')
                    ->leftJoin('access_logs', function ($join) {
                        $join->on('hub.thread_id', '=', 'access_logs.thread_id');
                    })
                    ->where('hub.thread_category', '=', $category)
                    ->where('hub.is_enabled', '=', 1)
                    ->groupBy('hub.thread_id')
                    ->get();
            }
        }

        $this->categorys = ThreadCategorys::get();
        $this->category_types = ThreadCategorys::select('category_type')
            ->distinct('category_type')
            ->get();
        $this->category_name = $request->category;
        $this->page = $request->page;
    }

    /**
     * Page Display
     *
     * @return \Illuminate\Support\Facades\View
     */
    public function render(Request $request)
    {
        return view('dashboard.threads');
    }
}
