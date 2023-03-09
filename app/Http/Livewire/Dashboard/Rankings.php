<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Hub;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Livewire\Component;

class Rankings extends Component
{
    /**
     * アクセスランキング
     *
     * @var \Illuminate\Support\Collection
     */
    public $access_ranking;

    /**
     * 週間アクセスランキング
     *
     * @var \Illuminate\Support\Collection
     */
    public $weekly_access_ranking;

    /**
     * このページで使用するデータの定義
     *
     * @link https://laravel-livewire.com/docs/2.x/rendering-components
     * @link https://readouble.com/laravel/9.x/ja/queries.html
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
     * ダッシュボードのアクセスランキングを表示
     *
     * @link https://laravel-livewire.com/docs/2.x/rendering-components
     * @see resources/views/dashboard/rankings.blade.php
     *
     * @return \Illuminate\Support\Facades\View
     */
    public function render()
    {
        return view('dashboard.rankings');
    }
}
