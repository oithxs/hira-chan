<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\Hub;

class Rankings extends Component
{
    public function render(Request $request)
    {
        $response['access_ranking'] = Hub::selectRaw('*, COUNT(*) AS access_count')
            ->rightjoin('access_logs', 'access_logs.thread_id', '=', 'hub.thread_id')
            ->whereNotNull('hub.thread_name')
            ->groupBy('hub.thread_id')
            ->orderByRaw('COUNT(*) DESC')
            ->get();

        return view('dashboard.rankings', $response);
    }
}
