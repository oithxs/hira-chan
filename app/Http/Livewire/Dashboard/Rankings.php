<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\Hub;

class Rankings extends Component
{
    public $access_ranking;

    public function mount(Request $request)
    {
        $this->access_ranking = Hub::selectRaw('*, COUNT(*) AS access_count')
            ->rightjoin('access_logs', 'access_logs.thread_id', '=', 'hub.thread_id')
            ->whereNotNull('hub.thread_name')
            ->groupBy('hub.thread_id')
            ->orderByRaw('COUNT(*) DESC')
            ->get();
    }

    public function render(Request $request)
    {
        return view('dashboard.rankings');
    }
}
