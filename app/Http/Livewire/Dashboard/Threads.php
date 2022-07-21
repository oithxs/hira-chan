<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\ThreadCategorys;
use App\Models\Hub;

class Threads extends Component
{
    public $threads;
    public $categorys;
    public $category_types;

    public function mount(Request $request)
    {
        $category = $request->category;
        $sort = $request->sort;

        if ($category == NULL) {
            if ($sort == 'new_create') {
                $this->threads = Hub::selectRaw('hub.*, COALESCE(COUNT(access_logs.access_log), 0) AS Access')
                    ->leftJoin('access_logs', function ($join) {
                        $join->on('hub.thread_id', '=', 'access_logs.thread_id');
                    })
                    ->groupBy('hub.thread_id')
                    ->orderByRaw('hub.created_at DESC')
                    ->get();
            } else if ($sort == 'access_count') {
                $this->threads = Hub::selectRaw('hub.*, COALESCE(COUNT(access_logs.access_log), 0) AS Access')
                    ->leftJoin('access_logs', function ($join) {
                        $join->on('hub.thread_id', '=', 'access_logs.thread_id');
                    })
                    ->groupBy('hub.thread_id')
                    ->orderByRaw('COUNT(access_logs.access_log) DESC')
                    ->get();
            } else {
                $this->threads = Hub::selectRaw('hub.*, COALESCE(COUNT(access_logs.access_log), 0) AS Access')
                    ->leftJoin('access_logs', function ($join) {
                        $join->on('hub.thread_id', '=', 'access_logs.thread_id');
                    })
                    ->groupBy('hub.thread_id')
                    ->get();
            }
        } else {
            if ($sort == 'new_create') {
                $this->threads = Hub::selectRaw('hub.*, COALESCE(COUNT(access_logs.access_log), 0) AS Access')
                    ->leftJoin('access_logs', function ($join) {
                        $join->on('hub.thread_id', '=', 'access_logs.thread_id');
                    })
                    ->where('hub.thread_category', '=', $category)
                    ->groupBy('hub.thread_id')
                    ->orderByRaw('hub.created_at DESC')
                    ->get();
            } else if ($sort == 'access_count') {
                $this->threads = Hub::selectRaw('hub.*, COALESCE(COUNT(access_logs.access_log), 0) AS Access')
                    ->leftJoin('access_logs', function ($join) {
                        $join->on('hub.thread_id', '=', 'access_logs.thread_id');
                    })
                    ->where('hub.thread_category', '=', $category)
                    ->groupBy('hub.thread_id')
                    ->orderByRaw('COUNT(access_logs.access_log) DESC')
                    ->get();
            } else {
                $this->threads = Hub::selectRaw('hub.*, COALESCE(COUNT(access_logs.access_log), 0) AS Access')
                    ->leftJoin('access_logs', function ($join) {
                        $join->on('hub.thread_id', '=', 'access_logs.thread_id');
                    })
                    ->where('hub.thread_category', '=', $category)
                    ->groupBy('hub.thread_id')
                    ->get();
            }
        }

        $this->categorys = ThreadCategorys::get();
        $this->category_types = ThreadCategorys::select('category_type')
            ->distinct('category_type')
            ->get();
    }

    public function render(Request $request)
    {
        $response['tables'] = $this->threads;
        $response['category_name'] = $request->category;
        $response['page'] = $request->page;

        return view('dashboard.threads', $response);
    }
}
