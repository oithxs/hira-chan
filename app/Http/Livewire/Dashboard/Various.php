<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;

class Various extends Component
{
    /**
     * ダッシュボードのお問い合わせリンクなどを表示する部分
     *
     * @link https://laravel-livewire.com/docs/2.x/rendering-components
     * @see resources/views/dashboard/various.blade.php
     *
     * @return \Illuminate\Support\Facades\View
     */
    public function render()
    {
        return view('dashboard.various');
    }
}
