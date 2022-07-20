<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Hub;
use Carbon\Carbon;

class Various extends Component
{
    public function render()
    {
        $week = Carbon::today()->subDay(7);
        $response['week_access_ranking'] = Hub::selectRaw('*, COUNT(*) AS access_count')
            ->rightjoin('access_logs', 'access_logs.thread_id', '=', 'hub.thread_id')
            ->whereNotNull('hub.thread_name')
            ->whereDate('access_logs.created_at', '>=', $week)
            ->groupBy('hub.thread_id')
            ->orderByRaw('COUNT(*) DESC')
            ->get();

        return view('dashboard.various', $response);
    }
}
