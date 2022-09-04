<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Hub;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Livewire\Component;

class Rankings extends Component
{
    /** @var \Illuminate\Support\Collection */
    public $access_ranking;

    /** @var \Illuminate\Support\Collection */
    public $weekly_access_ranking;

    /**
     * Storing data used on this page
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function mount(Request $request)
    {
        $week = Carbon::today()->subDay(7);

        $this->access_ranking = Hub::withCount('access_logs')
            ->orderBy('access_logs_count', 'desc')
            ->get();

        $this->weekly_access_ranking = Hub::withCount(['access_logs' => function (Builder $query) use ($week) {
            $query->whereDate('created_at', '>=', $week);
        }])->orderBy('access_logs_count', 'desc')
            ->get();
    }

    /**
     * Page Display
     *
     * @return \Illuminate\Support\Facades\View
     */
    public function render()
    {
        return view('dashboard.rankings');
    }
}
