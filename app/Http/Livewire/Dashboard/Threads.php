<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Hub;
use App\Models\ThreadCategory;
use Livewire\Component;
use Illuminate\Http\Request;

class Threads extends Component
{
    /** @var \Illuminate\Support\Collection */
    public $threads;

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
                    ->where('thread_category', '=', $request->category)
                    ->where('is_enabled', '=', 1)
                    ->orderBy('created_at', 'desc')
                    ->get();
            } else if ($request->sort == 'access_count') {
                $this->threads = Hub::withCount('access_logs')
                    ->where('thread_category', '=', $request->category)
                    ->where('is_enabled', '=', 1)
                    ->orderBy('access_logs_count', 'desc')
                    ->get();
            } else {
                $this->threads = Hub::withCount('access_logs')
                    ->where('thread_category', '=', $request->category)
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
     * Page Display
     *
     * @return \Illuminate\Support\Facades\View
     */
    public function render(Request $request)
    {
        return view('dashboard.threads');
    }
}
