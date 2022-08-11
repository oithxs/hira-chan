<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;

use App\Models\Hub;
use Carbon\Carbon;

use Illuminate\Http\Request;

class Rankings extends Component
{
    /** @var Illuminate\Support\Collection */
    public $access_ranking;

    /** @var Illuminate\Support\Collection */
    public $weekly_access_ranking;

    /**
     * Storing data used on this page
     *
     * @param Illuminate\Http\Request $request
     * @return void
     */

    public function mount(Request $request)
    {
        $week = Carbon::today()->subDay(7);

        $this->access_ranking = Hub::selectRaw('*, COUNT(*) AS access_count')
            ->rightjoin('access_logs', 'access_logs.thread_id', '=', 'hub.thread_id')
            ->whereNotNull('hub.thread_name')
            ->groupBy('hub.thread_id')
            ->orderByRaw('COUNT(*) DESC')
            ->get();

        $this->weekly_access_ranking = Hub::selectRaw('*, COUNT(*) AS access_count')
            ->rightjoin('access_logs', 'access_logs.thread_id', '=', 'hub.thread_id')
            ->whereNotNull('hub.thread_name')
            ->whereDate('access_logs.created_at', '>=', $week)
            ->groupBy('hub.thread_id')
            ->orderByRaw('COUNT(*) DESC')
            ->get();
    }

    /**
     * Page Display
     *
     * @return Illuminate\Support\Facades\View
     */

    public function render()
    {
        return view('dashboard.rankings');
    }
}
