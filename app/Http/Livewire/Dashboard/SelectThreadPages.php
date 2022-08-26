<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Hub;
use Livewire\Component;
use Illuminate\Http\Request;

class SelectThreadPages extends Component
{
    /** @var int */
    public $max_thread;

    /** @var string */
    public $sort;

    /** @var string */
    public $category;

    /**
     * Storing data used on this page
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function mount(Request $request)
    {
        if ($request->category == NULL) {
            $this->max_thread = Hub::count();
        } else {
            $this->max_thread = Hub::where('thread_category', '=', $request->category)
                ->count();
        }

        $this->sort = $request->sort;
        $this->category = $request->category;
    }

    /**
     * Page Display
     *
     * @return \Illuminate\Support\Facades\View
     */
    public function render()
    {
        return view('dashboard.select-thread-pages');
    }
}
